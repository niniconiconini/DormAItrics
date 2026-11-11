<?php

namespace App\Http\Controllers;

use App\Models\FaceRecognition;
use App\Models\PassSlip;
use App\Models\Resident;
use App\Models\ResidentLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FaceRecognitionController extends Controller
{
    public function scan(): RedirectResponse
    {
        // recognizing
        $output = shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\recognizeinator.py'.'" 2>&1');
        $residentId = (int) trim((string) $output);
        if (! $residentId) {
            return redirect()
                ->route('facial-recognition')
                ->with(
                    'message',
                    'Face not recognized. Please try again.'
                );
        }
        $resident = Resident::find($residentId);

        session(['recognized_resident_id' => $residentId, 'confirmIdentity' => true, 'recognized_resident_name' => $resident->user->nickname . ' ' . $resident->user->last_name]);

        return redirect()->route('facial-recognition');
    }

    public function confirm(): RedirectResponse
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
            $openLog->update([
                'returned_at' => now(),
            ]);
            session()->forget([
                'recognized_resident_id',
                'recognized_resident_name',
                'confirmIdentity',
                'scan_attempts',
            ]);

            return redirect()
                ->route('facial-recognition')
                ->with('message', 'Welcome back, ' . $resident->user->nickname . '!');
        }

        // check if pass slip has been used already
        $usedPassSlip = ResidentLog::where('resident_id', $residentId)
            ->whereDate('departed_at', today())
            ->exists();
        if ($usedPassSlip) {
            return redirect()
                ->route('facial-recognition')
                ->with('message', 'Hey '.$resident->user->nickname.', you have already used your pass slip for today.');
        }

        // checking pass slip
        /** @var Resident $resident */
        $activePassSlip = PassSlip::where('resident_id', $residentId)
            ->where('status', 'Approved')
            ->whereDate('requested_date_out', now()->toDateString())
            ->first();
        if (! $activePassSlip) {
            return redirect()
                ->route('facial-recognition')
                ->with('message', 'Hi '.$resident->user->nickname.'! you don\'t have an approved pass slip for today. Fill up one to go out.');
        }

        // if all success
        /** @var Resident $resident */
        ResidentLog::create([
            'resident_id' => $residentId,
            'departed_at' => now(),
        ]);

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
            'recognized_resident_name' => $resident->user->nickname . ' ' . $resident->user->last_name,
            'confirmIdentity' => true,
        ]);

        return redirect()
            ->route('facial-recognition');
    }

    public function enroll(Resident $resident): RedirectResponse
    {
        set_time_limit(300);
        // open python file
        shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\referenceinator.py" '.$resident->id.' 2>&1');
        shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\build_encodings.py" 2>&1');
        FaceRecognition::where('resident_id', $resident->id)->delete();
        for ($i = 1; $i <= 5; $i++) {
            FaceRecognition::create(['resident_id' => $resident->id, 'face_reference' => $resident->id.'_'.$i.'.jpg']);
        }

        return redirect()
            ->back()
            ->with('message', 'Face enrollment completed for ' . $resident->user->nickname . ' ' . $resident->user->lastname);
    }
}
