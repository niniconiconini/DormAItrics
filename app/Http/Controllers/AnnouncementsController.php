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
    public function index(): View
    {
        $announcements = Announcement::with('user')->latest()->get();

        return view('home', ['announcements' => $announcements]);
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request): RedirectResponse
    {
        // validate
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validate['title'],
            'message' => $validate['message'],
        ]);

        return redirect('home')->with('success', 'Announcement posted!');

    }
}
