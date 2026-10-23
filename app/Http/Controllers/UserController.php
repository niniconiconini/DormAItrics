<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $admins = User::whereIn('user_type', ['Admin', 'Manager'])->get();

        $residents = Resident::with(['user', 'room']);
        if (request('view') === 'transient') {
            $residents->where('accommodation_type', 'Transient');
        } else {
            $residents->where('accommodation_type', 'Resident');
        }

        if (request('resident_type')) {
            $residents->where('resident_type', request('resident_type'));
        }
        $residents = $residents->get();

        return view('residents', ['admins' => $admins, 'residents' => $residents]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'nickname' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8',
            'user_type' => 'required|in:Admin,Manager,Resident',
            'status' => 'required|in:Active,Inactive,Pending',
        ]);

        $user->update([
            'last_name' => $request->lastname,
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'nickname' => $request->nickname,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => $request->password,
            ]);
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

            $user->resident->update([
                'accommodation_type' => $request->accommodation_type,
                'resident_type' => $request->resident_type,
                'payment_schedule' => $request->payment_schedule,
                'room_type' => $request->room_type,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
            ]);
        }

        $receipt = [
            'action' => 'User Updated',
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
            ->with('success', 'User updated successfully.')
            ->with('receipt', $receipt);
    }
}
