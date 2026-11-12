<?php

namespace App\Http\Controllers;

use App\Models\ResidentLog;
use Illuminate\View\View;

class ResidentLogController extends Controller
{
    public function index(): View
    {
        $logs = ResidentLog::with(['resident.user'])
            ->latest('departed_at')
            ->get();

        return view(
            'logs', compact('logs')
        );
    }
}
