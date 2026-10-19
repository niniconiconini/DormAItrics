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
        // get rooms per dorm
        $query = Room::query();
        if (request('dorm')) {
            $query->where('dorm_name', request('dorm'));
        }

        $rooms = $query->orderby('room_number')->get();
        $roomsByDorm = $rooms->groupBy(fn ($room) => $room->dorm_name);
        $dormsOrder = collect(['Le Berceau', 'Maison Paul', 'Nini Dorm'])->mapWithKeys(function ($dorm) use ($roomsByDorm) {
            return [$dorm => $roomsByDorm->get($dorm, collect())];
        });

        return view('rooms', compact('roomsByDorm'));
    }

    // add button modal
    public function store(Request $request): RedirectResponse
    {

        // validate new inputs
        $validated = $request->validate([
            'room_number' => ['required', Rule::unique('rooms')],
            'dorm_name' => 'required',
            'capacity' => 'required|integer|min:1',
            'room_image' => 'required|image',
        ]);

        // validate image input again
        if ($request->hasFile('room_image')) {
            $validated['room_image'] = $request->file('room_image')->store('rooms', 'public');
        }

        // validation inputs for capacity depending on dorm
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

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room added successfuly!');
    }

    // edit room modal
    // public function update(Request $request, Room $room): RedirectResponse
    public function update(Request $request, Room $room)
    {
        // validate inputs
        $validated = $request->validate([
            'room_number' => ['required', Rule::unique('rooms')->ignore($room->id)],
            'dorm_name' => 'required',
            'capacity' => 'required|integer|min:1',
            'room_image' => 'nullable|image',
        ]);

        // validation inputs for capacity depending on dorm
        $allowedCapacities = match ($request->dorm_name) {
            'Le Berceau' => [2, 3, 4, 8],
            'Maison Paul' => [1, 2],
            default => [],
        };
        if (! in_array((int) $request->capacity, $allowedCapacities)) {
            return back()->withErrors([
                'capacity' => 'Invalid capacity for the selected dorm.',
            ])->withInput();
        }

        // validation for image input
        if ($request->hasFile('room_image')) {
            $validated['room_image'] = $request->file('room_image')->store('rooms', 'public');
        }

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }
}
