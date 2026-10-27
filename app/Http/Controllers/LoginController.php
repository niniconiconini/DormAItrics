<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            /** @var User $user */
            $user = Auth::user();
            // automatically deactivate residents whose checkout date has passed
            if (
                $user->resident &&
                $user->resident->check_out_date &&
                $user->resident->check_out_date < now()->toDateString()
            ) {
                // $user->update(['status' => 'Inactive',]);
                User::where('id', $user->id)->update(['status' => 'Inactive']);
                $user->resident->room_id = null;

                Auth::logout();

                return back()->withErrors(['email' => 'Your dormitory stay has expired, please contact the Dorm Manager or Dorm Admin.'])->onlyInput('email');
            }

            if ($user->status !== 'Active') {
                Auth::logout();

                return back()->withErrors(['email' => 'This account is inactive.'])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }
}
