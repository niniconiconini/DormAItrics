<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FaceRecognition;
use App\Models\PassSlip;
use App\Models\Resident;
use App\Models\ResidentLog;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FaceRecognitionController extends Controller
{
    public function scan(): RedirectResponse
    {
        // recognizing
        $output = shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\recognizeinator.py'.'" 2>&1');
        $residentId = (int) trim((string) $output);
        // $response = Http::timeout(20)->get('http://127.0.0.1:5000/scan');
        // $response = Http::withoutVerifying()->timeout(20)->get('https://blurred-roulette-unstuffed.ngrok-free.dev/scan');
        // $residentId = (int) trim($response->body());
        if (! $residentId) {
            $attempts = session('scan_attempts', 0) + 1;
            session(['scan_attempts' => $attempts]);
            session()->forget([
                'recognized_resident_id',
                'recognized_resident_name',
                'confirmIdentity',
            ]);
            if ($attempts >= 3) {
                return redirect()
                    ->route('facial-recognition')
                    ->with('message', 'Apologies, the scanner is currently having problems, please try manually.')
                    ->with('manualEntry', true);
            }

            return redirect()
                ->route('facial-recognition')
                ->with(
                    'message',
                    'Face not recognized. Please try again.'
                );
        }
        $resident = Resident::find($residentId);

        session(['recognized_resident_id' => $residentId, 'confirmIdentity' => true, 'recognized_resident_name' => $resident->user->nickname.' '.$resident->user->last_name]);

        return redirect()->route('facial-recognition');
    }

    public function confirm(Request $request): RedirectResponse
    {
        $residentId = session('recognized_resident_id');
        /** @var Resident $resident */
        $resident = Resident::findOrFail($residentId);

        // checking if resident has an open log before logging return or checking for pass slip
        $openLog = ResidentLog::where('resident_id', $residentId)
            ->whereNull('returned_at')
            ->latest()
            ->first();
        if ($openLog) {

            // DEBUG: Check values before updating
            logger()->debug('BEFORE UPDATE', [
                'id' => $openLog->id,
                'departed_at' => $openLog->getRawOriginal('departed_at'),
                'returned_at' => $openLog->getRawOriginal('returned_at'),
            ]);

            // Update ONLY returned_at
            $userId = Auth::id();
            /** @var positive-int $userId */
            $openLog->returned_at = now();
            $openLog->time_in_approver = $userId;

            // DEBUG: Check what Laravel is about to save
            logger()->debug('DIRTY ATTRIBUTES', [
                'dirty' => $openLog->getDirty(),
                'departed_at_changed' => $openLog->isDirty('departed_at'),
            ]);

            $openLog->save();

            // DEBUG: Check actual database values
            $freshLog = $openLog->fresh();

            logger()->debug('AFTER UPDATE', [
                'id' => $freshLog->id,
                'departed_at' => $freshLog->getRawOriginal('departed_at'),
                'returned_at' => $freshLog->getRawOriginal('returned_at'),
            ]);

            session()->forget([
                'recognized_resident_id',
                'recognized_resident_name',
                'confirmIdentity',
                'scan_attempts',
            ]);

            return redirect()
                ->route('facial-recognition')
                ->with('message', 'Welcome back, '.$resident->user->nickname.'!');
        }

        // checking pass slip
        /** @var Resident $resident */
        $activePassSlip = PassSlip::where('resident_id', $residentId)
            ->where('status', 'Approved')
            ->whereDate('requested_date_out', now()->toDateString())
            ->whereBetween('requested_time_out', [now()->copy()->subHour(), now()->copy()->addHour()])
            ->first();
        $todayPassSlip = PassSlip::where('resident_id', $residentId)
            ->where('status', 'Approved')
            ->whereDate('requested_date_out', now()->toDateString())
            ->first();
        session()->forget('confirmIdentity');
        if (! $activePassSlip) {
            session(['pending_no_pass_slip_resident_id' => $residentId]);

            return redirect()
                ->route('facial-recognition')
                ->with('overridePassSlip', true)
                ->with('requestedTimeOut', $todayPassSlip ? Carbon::parse($todayPassSlip->requested_time_out)->format('h:i A') : 'No Pass Slips');
        }

        // if all success
        /** @var Resident $resident */
        ResidentLog::create([
            'resident_id' => $residentId,
            'departed_at' => now(),
            'pass_slip_id' => $activePassSlip->id,
            'notes' => 'None',
            'time_out_approver' => Auth::id(),
        ]);

        $activePassSlip->update(['status' => 'Used']);

        session()->forget([
            'recognized_resident_id',
            'recognized_resident_name',
            'confirmIdentity',
            'scan_attempts',
        ]);

        return redirect()
            ->route('facial-recognition')
            ->with('message', 'Pass slip verified. Take care '.$resident->user->nickname.'!');
    }

    public function logWithoutPassSlip(Request $request): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|min:5|max:255']);
        $residentId = session('pending_no_pass_slip_resident_id');

        ResidentLog::create([
            'resident_id' => $residentId,
            'departed_at' => now(),
            'pass_slip_id' => null,
            'notes' => $request->notes,
            'time_out_approver' => Auth::id(),
        ]);

        session()->forget([
            'pending_no_pass_slip_resident_id',
            'recognized_resident_id',
            'recognized_resident_name',
            'confirmIdentity',
            'scan_attempts',
        ]);

        return redirect()
            ->route('facial-recognition')
            ->with('message', 'Resident log recorded.');
    }

    public function reject(): RedirectResponse
    {
        $attempts = session('scan_attempts', 0) + 1;
        session(['scan_attempts' => $attempts]);
        session()->forget([
            'recognized_resident_id',
            'recognized_resident_name',
            'confirmIdentity',
        ]);
        if ($attempts >= 3) {
            return redirect()
                ->route('facial-recognition')
                ->with('message', 'Apologies, the scanner is currently having problems, please try manually.')
                ->with('manualEntry', true);
        }

        return redirect()->route('facial-recognition');
    }

    public function manual(Request $request): RedirectResponse
    {
        $resident = Resident::whereHas('user', function ($query) use ($request) {
            $query->where(
                'email',
                $request->manualEntry
            );
        })->first();

        if (! $resident) {
            return redirect()
                ->route('facial-recognition')
                ->with('message', 'No resident was found with that email address.')
                ->with('manualEntry', true);
        }

        session()->forget('scan_attempts');

        session([
            'recognized_resident_id' => $resident->id,
            'recognized_resident_name' => $resident->user->nickname.' '.$resident->user->last_name,
            'confirmIdentity' => true,
        ]);

        return redirect()
            ->route('facial-recognition');
    }

    public function enroll(Resident $resident): RedirectResponse
    {
        set_time_limit(300);
        // open enroll face python file
        $output = trim((string) shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\referenceinator.py" '.$resident->id.' 2>&1'));
        // if cancelled
        if ($output === 'CANCELLED') {
            return redirect()
                ->back()
                ->with('face_cancelled', true)
                ->with('message', 'Face enrollment cancelled.');
        }

        shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\build_encodings.py" 2>&1');

        // if theres already previous, delete record then create
        FaceRecognition::where('resident_id', $resident->id)->delete();
        for ($i = 1; $i <= 5; $i++) {
            FaceRecognition::create(['resident_id' => $resident->id, 'face_reference' => $resident->id.'_'.$i.'.jpg']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_taken' => 'Face Enrolled',
        ]);

        return redirect()
            ->back()
            ->with('face_enrolled', true)
            ->with('message', 'Face enrollment completed for '.$resident->user->nickname.' '.$resident->user->last_name);
    }
}
