<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        User::firstOrCreate(
            ['email' => 'resurreccion.nini@gmail.com'
            ],
            [
                'name' => 'Nini',
                'password' => Hash::make('spum123'),
            ],
        );

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }
}



// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class LoginController extends Controller
// {
//     public function __invoke(Request $request): RedirectResponse
//     {
//         $credentials = $request->validate([
//             'email' => ['required', 'email'],
//             'password'=> ['required'],
//         ]);

//         if (Auth::attempt($credentials)) {
//             $request->session()->regenerate();
//             return redirect()->intended('home');
//         }

//         return back()->withErrors([
//             'email' => 'The provided credentials do not match our records',
//         ])->onlyInput('email');
//     }
    
// }


