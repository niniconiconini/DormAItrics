<?php

namespace App\Http\Controllers;

use App\Models\Concern;
use App\Models\ConcernReply;
use App\Models\Resident;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ConcernController extends Controller
{
    private function currentResident(): ?Resident
    {
        return Resident::where('user_id', Auth::id())->first();
    }

    public function index(): View
    {
        $resident = $this->currentResident();

        $concerns = Concern::with(['user', 'replies.user'])
            ->withCount('likedBy')
            ->withExists(['likedBy as liked_by_me' => fn ($query) => $query->where('users.id', Auth::id())])
            ->latest('id')
            ->get();

        return view('concerns', [
            'concerns' => $concerns,
            'canPost' => $resident !== null && ! Gate::allows('admins'),
        ]);

    }

    public function store(Request $request): RedirectResponse
    {
        $resident = $this->currentResident();
        abort_unless($resident !== null && ! Gate::allows('admins'), 403);

        $validated = $request->validate([
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:750',
        ]);

        Concern::create($validated + [
            'resident_id' => $resident->id,
        ]);

        return redirect()->route('concerns')->with('success', 'Concern submitted. It is now waiting to be reviewed.');
    }

    public function like(Request $request, Concern $concern): RedirectResponse|JsonResponse
    {
        $result = $concern->likedBy()->toggle(Auth::id());

        if ($request->wantsJson()) {
            return response()->json([
                'liked' => ! empty($result['attached']),
                'likes' => $concern->likedBy()->count(),
            ]);
        }

        return $this->backTo($concern);
    }

    public function reply(Request $request, Concern $concern): RedirectResponse|JsonResponse
    {
        $validated = $request->validateWithBag('reply', [
            'reply' => 'required|string|max:1000',
        ]);

        $reply = $concern->replies()->create([
            'user_id' => Auth::id(),
            'message' => $validated['reply'],
        ]);

        return $request->wantsJson() ? $this->replyJson($reply) : $this->backTo($concern);
    }

    private function backTo(Concern $concern): RedirectResponse
    {
        return redirect()->to(url()->previous().'#concern-'.$concern->id);
    }

    public function updateReply(Request $request, ConcernReply $reply): RedirectResponse|JsonResponse
    {
        abort_unless((int) $reply->user_id === (int) Auth::id(), 403);

        $validated = $request->validateWithBag('reply', [
            'reply' => 'required|string|max:1000',
        ]);

        $reply->update(['message' => $validated['reply']]);

        return $request->wantsJson() ? $this->replyJson($reply) : $this->backTo($reply->concern);
    }

    public function destroyReply(Request $request, ConcernReply $reply): RedirectResponse|JsonResponse
    {
        abort_unless((int) $reply->user_id === (int) Auth::id() || Gate::allows('admins'), 403);

        $reply->delete();

        return $request->wantsJson() ? $this->replyJson($reply) : $this->backTo($reply->concern);
    }

    public function destroy(Concern $concern): RedirectResponse
    {
        abort_unless(Gate::allows('admins'), 403);

        $concern->delete();

        return back()->with('success', 'Concern deleted.');
    }

    private function replyJson(ConcernReply $reply): JsonResponse
    {
        $reply->load('user');

        return response()->json([
            'html' => view('concernsreply', ['reply' => $reply])->render(),
            'count' => ConcernReply::where('concern_id', $reply->concern_id)->count(),
        ]);
    }
}
