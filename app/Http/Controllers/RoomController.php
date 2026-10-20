<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoomController extends Controller
{
    // =============================== VIEW PAGE ===============================
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
        })->filter(function ($rooms) {
            return $rooms->isNotEmpty();
        });

        return view('rooms', ['roomsByDorm' => $dormsOrder]);
    }

    // =============================== ADD ROOM ===============================
    public function store(Request $request): RedirectResponse
    {

        // validate inputs
        $validated = $request->validate([
            'room_number' => ['required', Rule::unique('rooms')->where(fn ($query) => $query->where('dorm_name', $request->dorm_name))],
            'dorm_name' => 'required',
            'capacity' => 'required|integer|min:1',
            'room_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [ // for error messages
            'room_number.required' => 'Please enter a room number.',
            'room_number.unique' => 'Room already exists.',
            'capacity.required' => 'Please select a room capacity.',
            'room_image.required' => 'Please upload a picture of the room',
            'room_image.image' => 'The selected file must be an image.',
            'room_image.max' => 'The image must not exceed 5 MB.',
        ]);

        // validate image input again
        if ($request->hasFile('room_image')) {
            // rename image to match dormNameRoomNumber.ext
            $dormAbbr = match ($request->dorm_name) {
                'Le Berceau' => 'lb',
                'Maison Paul' => 'mp',
                'Nini Dorm' => 'nd',
            };
            $imageName = $dormAbbr.$request->room_number.'.'.$request->file('room_image')->extension();
            // validate image input
            $request->file('room_image')->move(public_path('images/rooms'), $imageName);
            $validated['room_image'] = '/images/rooms/'.$imageName;
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

        return redirect('rooms')
            ->with(['success' => 'Room added successfully!',
                'receipt' => ['action' => 'Added',
                    'room_number' => $validated['room_number'],
                    'dorm_name' => $validated['dorm_name'],
                    'capacity' => $validated['capacity'],
                    'room_image' => $validated['room_image'],
                ]]);
    }

    // =============================== EDIT ROOM ===============================
    public function update(Request $request, Room $room)
    {
        // validate inputs
        $validated = $request->validate([
            'room_number' => ['required', Rule::unique('rooms')->where(fn ($query) => $query->where('dorm_name', $request->dorm_name))->ignore($room->id)],
            'dorm_name' => 'required',
            'capacity' => 'required|integer|min:1',
            'room_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [ // for error messages
            'room_number.required' => 'Please enter a room number.',
            'room_number.unique' => 'Room already exists.',
            'capacity.required' => 'Please select a room capacity.',
            'room_image.required' => 'Please upload a picture of the room',
            'room_image.image' => 'The selected file must be an image.',
            'room_image.max' => 'The image must not exceed 5 MB.',
        ]);

        // validate image input again
        if ($request->hasFile('room_image')) {
            // delete old image in project folder to be replaced
            if ($room->room_image && file_exists(public_path($room->room_image))) {
                unlink(public_path($room->room_image));
            }
            // rename new image
            $dormAbbr = match ($request->dorm_name) {
                'Le Berceau' => 'lb',
                'Maison Paul' => 'mp',
                'Nini Dorm' => 'nd',
            };
            $imageName = $dormAbbr.$request->room_number.'.'.$request->file('room_image')->extension();
            // validate image input
            $request->file('room_image')->move(public_path('images/rooms'), $imageName);
            $validated['room_image'] = '/images/rooms/'.$imageName;
        }

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

        $room->update($validated);

        return redirect()
            ->route('rooms.index')
            ->with(['success' => 'Room updated successfully!',
                'receipt' => ['action' => 'Updated',
                    'room_number' => $validated['room_number'],
                    'dorm_name' => $validated['dorm_name'],
                    'capacity' => $validated['capacity'],
                    'room_image' => $validated['room_image'] ?? null,
                ]]);
    }

    // =============================== DELETE ROOM ===============================
    public function destroy(Room $room): RedirectResponse
    {
        // delete image file
        if ($room->room_image && file_exists(public_path($room->room_image))) {
            unlink(public_path($room->room_image));
        }

        $receipt = [
            'action' => 'Deleted',
            'room_number' => $room->room_number,
            'dorm_name' => $room->dorm_name,
            'capacity' => $room->capacity,
            'image_deleted' => basename($room->room_image),
        ];

        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with(['success' => 'Room deleted successfully.',
                'receipt' => $receipt]);
    }
}
