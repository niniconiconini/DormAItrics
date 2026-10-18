<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $userData = $request->validate([
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'nickname' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'user_type' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('home');
    }
}
