<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status !== 'Active') {
                Auth::logout();

                return back()->withErrors(['email' => 'This account is inactive.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }
}
