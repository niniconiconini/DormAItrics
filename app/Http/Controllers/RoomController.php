<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Pest\Support\View;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::latest()->get();

        return view('rooms', ['rooms' => $rooms]);
    }

    // store room info
    // public function store(Request $request): RedirectResponse {
    //     // validate
    //     $validate = $request->validate([
    //         'room_number' => 'required'
    //     ]);
    // }
}
