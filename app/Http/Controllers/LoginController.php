<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Five failed login attempts trigger a five minute cooldown
    private const MAX_LOGIN_ATTEMPTS = 5;

    private const LOGIN_ATTEMPT_WINDOW_SECONDS = 900;

    private const LOGIN_COOLDOWN_SECONDS = 300;

    // show timer after refreshing the page
    public function show(Request $request): View
    {
        $lockedOutEmail = $request->session()->get('login_lockout_email');
        $lockoutNotice = null;

        if ($lockedOutEmail) {
            $baseKey = 'login:session:'.hash('sha256', $request->session()->getId());
            $lockoutKey = $baseKey.':lockout';

            if (RateLimiter::tooManyAttempts($lockoutKey, 1)) {
                $retryAfter = RateLimiter::availableIn($lockoutKey);
                $timeRemaining = sprintf('%dm %02ds', intdiv($retryAfter, 60), $retryAfter % 60);
                $lockoutNotice = "Remaining attempts: 0. Please try again in {$timeRemaining}.";
            } else {
                $request->session()->forget('login_lockout_email');
                $lockedOutEmail = null;
            }
        }

        return view('user-login', [
            'lockoutNotice' => $lockoutNotice,
            'lockedOutEmail' => $lockedOutEmail,
        ]);
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // keep separate attempt and cooldown counters for this browser session
        $baseKey = 'login:session:'.hash('sha256', $request->session()->getId());
        $attemptsKey = $baseKey.':attempts';
        $lockoutKey = $baseKey.':lockout';

        // block login only while the five-minute cooldown key is active.
        if (RateLimiter::tooManyAttempts($lockoutKey, 1)) {
            $request->session()->put('login_lockout_email', $credentials['email']);

            return back()
                ->onlyInput('email');
        }

        // start a fresh attempt count after the cooldown has ended
        if (RateLimiter::attempts($attemptsKey) >= self::MAX_LOGIN_ATTEMPTS) {
            RateLimiter::clear($attemptsKey);
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($attemptsKey);
            RateLimiter::clear($lockoutKey);
            $request->session()->forget('login_lockout_email');
            /** @var User $user */
            $user = Auth::user();

            if ($user->resident?->is_applicant) {
                Auth::logout();

                return back()->withErrors(['email' => 'Your application is still pending for approval'])->onlyInput('email');
            }

            // automatically deactivate residents whose checkout date has passed
            if (
                $user->resident &&
                $user->resident->check_out_date &&
                $user->resident->check_out_date < now()->toDateString()
            ) {

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

            if ($user->isGuard() && ! $user->isAdmin()) {
                return redirect()->route('logs.index');
            }

            return redirect()->route('home');
        }

        // keep failed attempts for 15 minutes; start a separate cooldown after attempt five
        RateLimiter::hit($attemptsKey, self::LOGIN_ATTEMPT_WINDOW_SECONDS);

        $remainingAttempts = max(
            0,
            self::MAX_LOGIN_ATTEMPTS - RateLimiter::attempts($attemptsKey)
        );

        if ($remainingAttempts === 0) {
            RateLimiter::hit($lockoutKey, self::LOGIN_COOLDOWN_SECONDS);

            $request->session()->put('login_lockout_email', $credentials['email']);

            $retryAfter = RateLimiter::availableIn($lockoutKey);
            $timeRemaining = sprintf('%dm %02ds', intdiv($retryAfter, 60), $retryAfter % 60);

            return back()
                ->onlyInput('email');
        }

        return back()->withErrors([
            'email' => "The provided credentials do not match our records.\nRemaining attempts: {$remainingAttempts}.",
        ])->onlyInput('email');
    }
}
