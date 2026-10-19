<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
// use Pest\Support\View;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {

        $query = Room::query();
        if (request('dorm')) {
            $query->where('dorm_name', request('dorm'));
        }

        $rooms = $query->latest()->get();
        $roomsByDorm = $rooms->groupBy(fn ($room) => $room->dorm_name);

        return view('rooms', compact('roomsByDorm'));
    }

    // store room info
    public function store(Request $request): void {}
}
