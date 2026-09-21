<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $userData =$request->validate([
            'lastname' => ['required','string'],
            'firstname' => ['required','string'],
            'nickname' => ['required','string'],
            'birthdate' => ['required','date'],
            'user_type' => ['required','string'],
            'address' => ['required','string'],
            'cellphone' => ['required','string'],
            'email' => ['required','email'],
            'password' => ['required','string'],
            'accommodation_type' => ['required','string'],
            'payment_schedule' => ['required','string'],
        ]);
        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);

        Auth::login($user);
        return redirect()->route('home');
    }
}
