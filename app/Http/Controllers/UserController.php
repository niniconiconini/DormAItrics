<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        // get active users
        $admins = User::whereIn('user_type', ['Admin', 'Manager'])
            ->where('status', 'Active')
            ->get();

        $residents = Resident::with(['user', 'room']);
        if (request('view') === 'transient') {
            $residents->where('accommodation_type', 'Transient');
        } else {
            $residents->where('accommodation_type', 'Resident');
        }

        if (request('resident_type')) {
            $residents->where('resident_type', request('resident_type'));
        }
        $residents = $residents->get()->filter(function ($resident) {
            return $resident->user->status === 'Active';
        });

        // get inaactive users
        $inactiveUsers = User::with('resident')
            ->where('status', 'Inactive')
            ->orderByRaw("CASE
                            WHEN user_type = 'Admin' THEN 1
                            WHEN user_type = 'Manager' THEN 2
                            WHEN user_type = 'Resident' THEN 3
                            ELSE 4
                        END")->get();

        return view('residents', ['admins' => $admins,
            'residents' => $residents,
            'inactiveUsers' => $inactiveUsers, ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8',
            'user_type' => 'required|in:Admin,Manager,Resident',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->user_type === 'Resident') {
            $request->validate([
                'resident_type' => 'required|in:Student,Employee',
                'accommodation_type' => 'required|in:Resident,Transient',
                'payment_schedule' => 'required|string',
                'room_type' => 'required|string',
                'check_in_date' => 'required|date',
                'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            ]);
        }

        // set defaults
        $password = $request->filled('password') ? $request->password : 'spum123';
        $validated['password'] = $password;
        $profilePicture = '/images/users/user-profile.png';
        $validated['profile_picture'] = $profilePicture;
        $validated['status'] = 'Active';

        // create user
        $user = User::create($validated);

        // rename profile picture once user id has been created
        if ($request->hasFile('profile_picture')) {
            // rename new image
            $imageName = 'user_'.$user->id.'.'.$request->file('profile_picture')->extension();

            // validate image input
            $request->file('profile_picture')->move(public_path('images/users'), $imageName);
            $user->update(['profile_picture' => '/images/users/'.$imageName]);
        }

        if ($user->user_type === 'Resident') {
            Resident::create([
                'user_id' => $user->id,
                'room_id' => null,
                'resident_type' => $request->resident_type,
                'accommodation_type' => $request->accommodation_type,
                'payment_schedule' => $request->payment_schedule,
                'room_type' => $request->room_type,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
            ]);
            $user->load('resident');
        }

        $receipt = [
            'action' => 'User Created',
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'nickname' => $user->nickname,
            'birthdate' => $user->birthdate?->format('F d, Y'),
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'email' => $user->email,
            'user_type' => $user->user_type,
            'status' => $user->status,
            'password_updated' => false,
        ];

        if ($user->resident) {
            $receipt['accommodation_type'] = $user->resident->accommodation_type;
            $receipt['resident_type'] = $user->resident->resident_type;
            $receipt['payment_schedule'] = $user->resident->payment_schedule;
            $receipt['room_type'] = $user->resident->room_type;
            $receipt['check_in_date'] = $user->resident->check_in_date?->format('F d, Y');
            $receipt['check_out_date'] = $user->resident->check_out_date?->format('F d, Y');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully!')
            ->with('receipt', $receipt);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $userActivated = false;
        $currentUser = Auth::user();
        if ($currentUser->id !== $user->id && $currentUser->user_type !== 'Admin') {
            abort(403);
        }

        if ($user->status === 'Inactive' && $request->status === 'Active') {
            $request->merge([
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'nickname' => $user->nickname,
                'birthdate' => $user->birthdate?->format('Y-m-d'),
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'email' => $user->email,
                'password_updated' => $request->filled('password'),
                'user_type' => $user->user_type,
                'status' => 'Active',
                'room_image' => $user->profile_picture,
            ]);
            $userActivated = true;
        }

        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'nickname' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8',
            'user_type' => 'required|in:Admin,Manager,Resident',
            'status' => 'required|in:Active,Inactive,Pending',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        if ($currentUser->id === $user->id && $currentUser->user_type === 'Resident') {
            $validated['user_type'] = $user->user_type;
            $validated['status'] = $user->status;
        }

        if ($currentUser->id === $user->id && $currentUser->user_type === 'Manager') {
            $validated['user_type'] = $user->user_type;

            if ($validated['status'] === 'Inactive') {
                $validated['status'] = $user->status;
            }
        }

        $user->update($validated); // create user

        if ($user->status === 'Inactive' && $user->resident) {
            $user->resident->update(['room_id' => null]);
        }

        if ($request->filled('password')) {
            $user->update(['password' => $request->password]);
        }

        if ($request->has('reset_password')) {
            $user->update(['password' => 'spum123']);
        }

        if ($user->resident) {
            $validated = $request->validate([
                'resident_type' => 'nullable|in:Student,Employee',
                'accommodation_type' => 'nullable|in:Resident,Transient',
                'payment_schedule' => 'nullable|string',
                'room_type' => 'nullable|string',
                'check_in_date' => 'nullable|date',
                'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            ]);

            if ($currentUser->id === $user->id && $currentUser->user_type === 'Resident') {
                $validated['resident_type'] = $user->resident->resident_type;
                $validated['accommodation_type'] = $user->resident->accommodation_type;
                $validated['payment_schedule'] = $user->resident->payment_schedule;
                $validated['room_type'] = $user->resident->room_type;
                $validated['check_in_date'] = $user->resident->check_in_date;
                $validated['check_out_date'] = $user->resident->check_out_date;
            }

            $user->resident->update($validated); // create resident
        }

        if ($request->hasFile('profile_picture')) {
            // delete image being replaced
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            // rename new image
            $imageName = 'user_'.$user->id.'.'.$request->file('profile_picture')->extension();

            // validate image input
            $request->file('profile_picture')->move(public_path('images/users'), $imageName);
            $user->update(['profile_picture' => '/images/users/'.$imageName]);
        }

        $receipt = [
            'action' => $userActivated ? 'User Activated' : 'User Updated',
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'nickname' => $user->nickname,
            'birthdate' => $user->birthdate?->format('F d, Y'),
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'email' => $user->email,
            'password_updated' => $request->filled('password'),
            'user_type' => $user->user_type,
            'status' => $user->status,
            'room_image' => $user->profile_picture,
        ];

        if ($user->resident) {
            $receipt['accommodation_type'] = $user->resident->accommodation_type;
            $receipt['resident_type'] = $user->resident->resident_type;
            $receipt['payment_schedule'] = $user->resident->payment_schedule;
            $receipt['room_type'] = $user->resident->room_type;
            $receipt['check_in_date'] = $user->resident->check_in_date?->format('F d, Y');
            $receipt['check_out_date'] = $user->resident->check_out_date?->format('F d, Y');
        }

        $successMessage = $userActivated ? 'User activated successfully.' : 'User updated successfully.';

        // show confirmation after creating account
        if ($currentUser->id === $user->id) {
            return redirect()
                ->route('profile')
                ->with('success', $successMessage)
                ->with('receipt', $receipt);
        }

        return redirect()
            ->route('users.index')
            ->with('success', $successMessage)
            ->with('receipt', $receipt);
    }
}
