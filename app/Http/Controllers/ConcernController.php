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

    private function ensureVisibleToCurrentUser(Concern $concern): void
    {
        $resident = $this->currentResident();
        $isOwner = $resident !== null && (int) $concern->resident_id === (int) $resident->id;

        abort_unless($concern->visibility === 'public' || $isOwner || Gate::allows('admins'), 404);
    }

    public function index(Request $request): View|RedirectResponse
    {
        $resident = $this->currentResident();
        $isAdmin = Gate::allows('admins');
        // admins can switch between public and private. Show public by default.
        $visibility = $request->query('visibility') === 'private' ? 'private' : 'public';

        $query = Concern::query();

        if ($isAdmin) {
            // admins can view all concerns of the selected visibility.
            $query->where('visibility', $visibility);
        } elseif ($visibility === 'private') {
            // dormers can only see their own private concerns.
            $query->where('visibility', 'private')
                ->where('resident_id', $resident?->id ?? 0);
        } else {
            // public concerns are visible to all dormers.
            $query->where('visibility', 'public');
        }

        $concerns = $query->with(['user', 'replies.user'])
            ->withCount('likedBy')
            ->withExists(['likedBy as liked_by_me' => fn ($query) => $query->where('users.id', Auth::id())])
            ->latest('id')
            ->paginate(7)
            ->withQueryString()
            ->fragment('concerns-list');

        if ($concerns->isEmpty() && $concerns->currentPage() > 1) {
            return redirect($concerns->url($concerns->lastPage()));
        }

        return view('concerns', [
            'concerns' => $concerns,
            'canPost' => $resident !== null && ! $isAdmin,
            'visibility' => $visibility,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $resident = $this->currentResident();
        abort_unless($resident !== null && ! Gate::allows('admins'), 403);

        $validated = $request->validate([
            'message' => 'required|string|max:750',
            'visibility' => 'required|in:public,private',
        ]);

        Concern::create([
            'resident_id' => $resident->id,
            'message' => $validated['message'],
            'visibility' => $validated['visibility'],
            'status' => 'pending',
        ]);

        return redirect()->route('concerns', ['visibility' => $validated['visibility']])->with('success', 'Concern submitted. It is now waiting to be reviewed.');
    }

    public function like(Request $request, Concern $concern): RedirectResponse|JsonResponse
    {
        $this->ensureVisibleToCurrentUser($concern);
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
        $this->ensureVisibleToCurrentUser($concern);
        $validated = $request->validateWithBag('reply', [
            'reply' => 'required|string|max:500',
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
        $this->ensureVisibleToCurrentUser($reply->concern);
        abort_unless((int) $reply->user_id === (int) Auth::id(), 403);

        $validated = $request->validateWithBag('reply', [
            'reply' => 'required|string|max:500',
        ]);

        $reply->update(['message' => $validated['reply']]);

        return $request->wantsJson() ? $this->replyJson($reply) : $this->backTo($reply->concern);
    }

    public function destroyReply(Request $request, ConcernReply $reply): RedirectResponse|JsonResponse
    {
        $this->ensureVisibleToCurrentUser($reply->concern);
        abort_unless((int) $reply->user_id === (int) Auth::id() || Gate::allows('admins'), 403);

        $reply->delete();

        return $request->wantsJson() ? $this->replyJson($reply) : $this->backTo($reply->concern);
    }

    public function updateStatus(Request $request, Concern $concern): RedirectResponse
    {
        abort_unless(Gate::allows('admins'), 403);

        $validated = $request->validate([
            'status' => 'required|in:acknowledged,resolved',
        ]);

        $concern->update(['status' => $validated['status']]);

        return back()->with('success', 'Concern status updated.');
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
