<?php

namespace App\Http\Controllers;

use App\Models\PassSlip;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PassSlipController extends Controller
{
    private function currentResident(): ?Resident
    {
        return Resident::where('user_id', Auth::id())->first();
    }

    /**
     * @return array<int, string|\Closure>
     */
    private function timeRules(string $label): array
    {
        return [
            'bail',
            'required',
            'date_format:H:i',
            function ($attribute, $value, $fail) use ($label) {
                if ($value > '21:00') {
                    $fail("$label cannot be later than 9:00 PM (curfew).");
                } elseif ((int) substr($value, 3, 2) % 10 !== 0) {
                    $fail("$label must be in 10-minute steps (for example 4:00 or 4:10).");
                }
            },
        ];
    }

    public function index(): View
    {
        $resident = $this->currentResident();
        $passSlips = PassSlip::where('resident_id', $resident->id ?? 0)
            ->whereNull('cleared_at')
            ->latest('id')
            ->paginate(8)
            ->fragment('previous');

        $user = Auth::user();
        $fullName = collect([$user->first_name, $user->middle_name, $user->last_name])->filter()->implode(' ');

        return view('slips', compact('passSlips', 'fullName'));
    }

    public function store(Request $request): RedirectResponse
    {
        $resident = $this->currentResident();
        abort_unless($resident !== null, 403);

        $validated = $request->validate([
            'requested_date_out' => 'required|date|after_or_equal:today',
            'requested_time_out' => $this->timeRules('Time out'),
            'purpose' => 'required|string|max:255',
            'requested_date_in' => 'required|date|after_or_equal:requested_date_out',
            'requested_time_in' => $this->timeRules('Expected return time'),
        ]);

        $out = Carbon::parse($validated['requested_date_out'].' '.$validated['requested_time_out']);
        if ($out->isPast()) {
            return back()->withErrors([
                'requested_time_out' => 'Time out cannot be in the past.',
            ])->withInput();
        }
        $in = Carbon::parse($validated['requested_date_in'].' '.$validated['requested_time_in']);
        if ($in->lessThanOrEqualTo($out)) {
            return back()->withErrors([
                'requested_time_in' => 'Expected return time must be after your time out.',
            ])->withInput();
        }

        PassSlip::create($validated + [
            'resident_id' => $resident->id,
            'status' => 'Pending',
        ]);

        return redirect()->route('pass-slips')->with('success', 'Pass slip submitted. It is now waiting for approval.');
    }

    // cancel button (only while still "For approval")
    public function cancel(PassSlip $passSlip): RedirectResponse
    {
        $resident = $this->currentResident();
        abort_unless($resident && $passSlip->resident_id === $resident->id, 403);

        if ($passSlip->displayStatus() !== 'For approval') {
            return back()->with('error', 'Only pass slips that are still for approval can be cancelled.');
        }

        $passSlip->update(['status' => 'Cancelled']);

        return back()->with('success', 'Pass slip request cancelled.');
    }
}
