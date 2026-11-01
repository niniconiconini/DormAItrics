<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementsController extends Controller
{
    /* get announcements from db and get user */
    public function index(): View|RedirectResponse
    {
        $announcements = Announcement::with('user')
            ->latest('id')
            ->paginate(5)
            ->fragment('list-view');

        if ($announcements->isEmpty() && $announcements->currentPage() > 1) {
            return redirect($announcements->url($announcements->lastPage()));
        }

        return view('home', ['announcements' => $announcements]);
    }

    public function store(Request $request): RedirectResponse
    {
        // validate
        $validate = $request->validate([
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:750',
        ]);

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validate['title'],
            'message' => $validate['message'],
        ]);

        return redirect('')->with('success', 'Announcement posted!');

    }

    /* edit button */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $this->authorizeOwner($announcement);

        $validate = $request->validate([
            'title' => 'required|string|max:200',
            'message' => 'required|string|max:750',
        ]);

        $announcement->update($validate);

        return back()->with('success', 'Announcement updated!');
    }

    /* delete button */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->authorizeOwner($announcement);

        $announcement->delete();

        return back()->with('success', 'Announcement deleted.');
    }

    // stops anyone except the author from changing an announcement
    private function authorizeOwner(Announcement $announcement): void
    {
        abort_unless((int) $announcement->user_id === (int) Auth::id(), 403);
    }
}
