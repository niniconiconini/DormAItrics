<?php

namespace App\Http\Controllers;

use App\Models\PassSlip;
use App\Models\Resident;
use App\Models\ResidentLog;

class FaceRecognitionController extends Controller
{
    public function scan(): string
    {
        // recognizing
        $output = shell_exec('"'.dirname(base_path()).'\facial-recognition\venv\Scripts\python.exe" "'.dirname(base_path()).'\facial-recognition\recognizeinator.py'.'" 2>&1');
        $residentId = (int) trim((string) $output);
        if (! $residentId) {
            return 'Face not recognized, please try again.';
        }
        $resident = Resident::find($residentId);

        // checking if resident has an open log before logging return or checking for pass slip
        $openLog = ResidentLog::where('resident_id', $residentId)
            ->whereNull('returned_at')
            ->latest()
            ->first();
        if ($openLog) {
            $openLog->update([
                'returned_at' => now(),
            ]);

            return 'Welcome back, '.$resident->user->nickname.'!';
        }

        // check if pass slip has been used already
        $usedPassSlip = ResidentLog::where('resident_id', $residentId)
            ->whereDate('departed_at', today())
            ->exists();

        if ($usedPassSlip) {
            return 'You have already used your pass slip for today.';
        }

        // checking pass slip
        $activePassSlip = PassSlip::where('resident_id', $residentId)
            ->where('status', 'Approved')
            ->whereDate('requested_date_out', now()->toDateString())
            ->first();
        if (! $activePassSlip) {
            return 'You don\'t have an approved pass slip for today anymore. Fill up another one to go out again.';
        }
        ResidentLog::create([
            'resident_id' => $residentId,
            'departed_at' => now(),
        ]);

        return 'Pass slip verfied. Take care!';
    }

    public function enroll(Resident $resident): string
    {
        // add face recognition reference to student
        return 'Enrolling face for resident: '.$resident->user->nickname;
    }
}
