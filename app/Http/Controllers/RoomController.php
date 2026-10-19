<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {

        $query = Room::query();
        if (request('dorm')) {
            $query->where('dorm_name', request('dorm'));
        }

        $rooms = $query->orderby('room_number')->get();
        $roomsByDorm = $rooms->groupBy(fn ($room) => $room->dorm_name);

        return view('rooms', compact('roomsByDorm'));
    }

    // store room info
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // 'room_number' => 'required',
            'room_number' => ['required',
                Rule::unique('rooms')->where(function ($query) use ($request) {
                    return $query->where('dorm_name', $request->dorm_name);
                })],
            'dorm_name' => 'required',
            'capacity' => 'required|integer|min:1',
            'room_image' => 'required|image',
        ]);

        // validation for capacity
        $allowedCapacities = match ($request->dorm_name) {
            'Le Berceau' => [2, 3, 4, 8],
            'Maison Paul' => [1, 2],
            default => [],
        };
        if (! in_array($request->capacity, $allowedCapacities)) {
            return back()->withErrors([
                'capacity' => 'Invalid capacity for the selected dorm.',
            ])->withInput();
        }

        // validation for image input
        if ($request->hasFile('room_image')) {
            $validated['room_image'] = $request->file('room_image')->store('rooms', 'public');
        }

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room added successfuly!');
    }
}
