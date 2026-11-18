<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    // =============================== VIEW USERS ===============================
    public function index(): View
    {
        // get users
        $admins = User::whereIn('user_type', ['Admin', 'Manager', 'Guard'])
            ->where('status', 'Active')
            ->get();
        $allAccounts = User::with('resident.room');
        $inactiveAccounts = User::with(['status', 'inactive']);
        $residents = Resident::with(['user', 'room']);

        switch (request('view', 'resident')) {
            case 'transient':
                $residents = Resident::with(['user', 'room'])
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'Active')
                            ->where('is_applicant', false)
                            ->where('accommodation_type', 'Transient');
                    });
                break;
            case 'applicant':
                $residents = Resident::with(['user', 'room'])
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'Active')
                            ->where('is_applicant', true);
                    });
                break;
            case 'inactive':
                $inactiveAccounts = User::with('resident.room')->where('status', 'Inactive')->get();
                break;
            case 'all':
                $allAccounts = User::with('resident.room')->paginate(10)->withQueryString();
                break;
            default:
                $residents = Resident::with(['user', 'room'])
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'Active')
                            ->where('is_applicant', false)
                            ->where('accommodation_type', 'Resident');
                    });
                break;
        }

        if (request('resident_type')) {
            $residents->where('resident_type', request('resident_type'));
        }

        if (request('search')) {
            $search = request('search');
            $residents->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $residents = $residents->paginate(10)->withQueryString();

        return view('residents', [
            'admins' => $admins,
            'inactiveAccounts' => $inactiveAccounts,
            'allAccounts' => $allAccounts,
            'residents' => $residents,
        ]);
    }

    // =============================== CREATE USERS ===============================
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'last_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'first_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:75'],
            'middle_name' => ['nullable', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'nickname' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:15'],
            'birthdate' => 'required|date',
            'gender' => 'required|in:Female,Male',
            'phone_number' => 'nullable|regex:/^09\d{9}$/',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8',
            'user_type' => 'required|in:Admin,Manager,Guard,Resident',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->user_type === 'Resident') {
            $request->validate([
                'resident_type' => 'required|in:Student,Employee',
                'accommodation_type' => 'required|in:Resident,Transient',
                'payment_schedule' => 'required|string',
                'room_type' => 'required|string',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);
        }

        // set defaults
        $password = $request->filled('password') ? $request->password : 'spum123';
        $validated['password'] = $password;
        $profilePicture = '/images/users/user-profile.png';
        $validated['profile_picture'] = $profilePicture;
        $validated['status'] = 'Active';

        // auto capitalize name
        $validated['last_name'] = ucwords(strtolower($validated['last_name']));
        $validated['first_name'] = ucwords(strtolower($validated['first_name']));
        $validated['middle_name'] = ! empty($validated['middle_name']) ? ucwords(strtolower($validated['middle_name'])) : null;
        $validated['nickname'] = ucwords(strtolower($validated['nickname']));

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
            'birthdate' => $user->birthdate->format('F d, Y'),
            'gender' => $user->gender,
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
            $receipt['check_in_date'] = Carbon::parse($user->resident->check_in_date)->format('F d, Y');
            $receipt['check_out_date'] = Carbon::parse($user->resident->check_out_date)->format('F d, Y');
        }

        ActivityLog::create(['user_id' => Auth::id(), 'action_taken' => 'User Created']);

        return redirect()
            ->route('users.index', ['view' => $request->accommodation_type === 'Transient' ? 'transient' : 'resident'])
            ->with('success', 'User created successfully!')
            ->with('receipt', $receipt);
    }

    // =============================== APPLICANTS ===============================
    public function applicant(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'last_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'first_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:75'],
            'middle_name' => ['nullable', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'nickname' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:15'],
            'birthdate' => 'required|date',
            'gender' => 'required|in:Female,Male',
            'phone_number' => 'nullable|regex:/^09\d{9}$/',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'user_type' => 'required|in:Resident',
            'resident_type' => 'required|in:Student,Employee',
            'accommodation_type' => 'required|in:Resident,Transient',
            'payment_schedule' => 'required|string',
            'room_type' => 'required|string',
        ]);

        // set defaults
        $validated['status'] = 'Active';
        $validated['profile_picture'] = '/images/users/user-profile.png';

        // auto capitalize name
        $validated['last_name'] = ucwords(strtolower($validated['last_name']));
        $validated['first_name'] = ucwords(strtolower($validated['first_name']));
        $validated['middle_name'] = ! empty($validated['middle_name']) ? ucwords(strtolower($validated['middle_name'])) : null;
        $validated['nickname'] = ucwords(strtolower($validated['nickname']));

        // create user
        $user = User::create($validated);

        Resident::create([
            'user_id' => $user->id,
            'room_id' => null,
            'is_applicant' => true,
            'resident_type' => $request->resident_type,
            'accommodation_type' => $request->accommodation_type,
            'payment_schedule' => $request->payment_schedule,
            'room_type' => $request->room_type,
        ]);

        return redirect()
            ->route('apply')
            ->with('application_submitted', true);
    }

    // =============================== APPROVE APPLICANTS ===============================
    public function approveApplicant(Resident $resident): RedirectResponse
    {
        $resident->update(['is_applicant' => false]);
        ActivityLog::create(['user_id' => Auth::id(), 'action_taken' => 'Applicant Approved']);

        return redirect()->route('users.index', ['view' => $resident->accommodation_type === 'Transient' ? 'transient' : 'resident', 'modal' => 'edit-user', 'user' => $resident->user_id])->with('success', 'Applicant approved successfully. Please update check in and check out dates.');
    }

    // =============================== UPDATE USERS ===============================
    public function update(Request $request, User $user): RedirectResponse
    {
        $userActivated = false;
        $currentUser = Auth::user();
        if ($currentUser->user_type === 'Manager' && $currentUser->id !== $user->id && $user->user_type !== 'Resident') {
            abort(403);
        }

        // get inactive user info and restore once reactivated
        if ($user->status === 'Inactive' && $request->status === 'Active') {
            $request->merge([
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'nickname' => $user->nickname,
                'birthdate' => $user->birthdate->format('Y-m-d'),
                'gender' => $user->gender,
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

        // make sure user inputs are valid
        $validated = $request->validate([
            'last_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'first_name' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:75'],
            'middle_name' => ['nullable', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:25'],
            'nickname' => ['required', 'regex:/^[\pL]+(?:[\s.,-][\pL]+)*$/u', 'max:15'],
            'gender' => 'required|in:Female,Male',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|regex:/^09\d{9}$/',
            'address' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8',
            'user_type' => 'required|in:Admin,Manager,Guard,Resident',
            'status' => 'required|in:Active,Inactive,Pending',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // leave password input blank to keep old user password
        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        // block residents from being able to change user type to be other than resident or deactivate their account
        if ($currentUser->id === $user->id && $currentUser->user_type === 'Resident') {
            $validated['user_type'] = $user->user_type;
            $validated['status'] = $user->status;
        }

        // prevents admins manager from changing THEIR OWN user type and status
        if ($currentUser->id === $user->id && in_array($currentUser->user_type, ['Admin', 'Manager'])) {
            $validated['user_type'] = $user->user_type;

            if ($validated['status'] === 'Inactive') {
                $validated['status'] = $user->status;
            }
        }

        // auto capitalize name
        $validated['last_name'] = ucwords(strtolower($validated['last_name']));
        $validated['first_name'] = ucwords(strtolower($validated['first_name']));
        $validated['middle_name'] = ! empty($validated['middle_name']) ? ucwords(strtolower($validated['middle_name'])) : null;
        $validated['nickname'] = ucwords(strtolower($validated['nickname']));

        $wasActive = $user->status === 'Active';
        $user->update($validated); // update user
        $user->refresh();

        // reset resident info when turning user inactive
        if ($user->status === 'Inactive' && $user->resident) {
            $user->resident->update([
                'room_id' => null,
            ]);
        }

        // update password if input is filled
        if ($request->filled('password')) {
            $user->update(['password' => $request->password]);
        }

        // change password to default when reset button has been pressed
        if ($request->has('reset_password')) {
            $user->update(['password' => 'spum123']);
        }

        // update resident
        if ($user->resident) {
            // validate inputs
            $validated = $request->validate([
                'resident_type' => 'required|in:Student,Employee',
                'accommodation_type' => 'required|in:Resident,Transient',
                'payment_schedule' => 'required|string',
                'room_type' => 'required|string',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);

            // lock changing resident info for residents
            if ($currentUser->id === $user->id && $currentUser->user_type === 'Resident') {
                $validated['resident_type'] = $user->resident->resident_type;
                $validated['accommodation_type'] = $user->resident->accommodation_type;
                $validated['payment_schedule'] = $user->resident->payment_schedule;
                $validated['room_type'] = $user->resident->room_type;
                $validated['check_in_date'] = $user->resident->check_in_date;
                $validated['check_out_date'] = $user->resident->check_out_date;
            }

            // remove resident from room if any of these are changed
            $resident = $user->resident;
            $residentInfoChanged =
                $resident->room_type !== ($request->room_type ?? $resident->room_type) ||
                $resident->resident_type !== ($request->resident_type ?? $resident->resident_type) ||
                $resident->accommodation_type !== ($request->accommodation_type ?? $resident->accommodation_type) ||
                $user->gender !== ($request->gender ?? $user->gender);
            if ($residentInfoChanged) {
                $resident->update(['room_id' => null]);
            }

            $user->resident->update($validated); // create resident / update resident
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
            'birthdate' => $user->birthdate->format('F d, Y'),
            'gender' => $user->gender,
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
            $receipt['check_in_date'] = Carbon::parse($user->resident->check_in_date)->format('F d, Y');
            $receipt['check_out_date'] = Carbon::parse($user->resident->check_out_date)->format('F d, Y');
        }

        $successMessage = $userActivated ? 'User activated successfully.' : 'User updated successfully.';

        // show confirmation after creating account
        if ($currentUser->id === $user->id) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action_taken' => 'Profile Updated',
            ]);

            return redirect()
                ->route('profile')
                ->with('success', $successMessage)
                ->with('receipt', $receipt);
        }

        if ($wasActive && $user->status === 'Inactive') {
            ActivityLog::create(['user_id' => Auth::id(),
                'action_taken' => 'User Deactivated',
            ]);
        } else {
            ActivityLog::create(['user_id' => Auth::id(),
                'action_taken' => $userActivated
                    ? 'User Activated'
                    : 'User Updated',
            ]);
        }

        return redirect()
            ->route('users.index', ['view' => $user->resident?->accommodation_type === 'Transient' ? 'transient' : 'resident'])
            ->with('success', $successMessage)
            ->with('receipt', $receipt);
    }
}
