<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ResidentLog;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResidentLogController extends Controller
{
    public function index(): View
    {
        $logs = ResidentLog::with([
            'resident.user',
            'timeOutApprover',
            'timeInApprover',
        ])->latest()->paginate(10);

        $activityLogs = ActivityLog::with('user')->latest()->paginate(10, ['*'], 'activities');
        $selectedLog = null;

        if (request('modal')) {
            $selectedLog = ResidentLog::find(request('modal'));
        }

        return view('logs', [
            'logs' => $logs,
            'activityLogs' => $activityLogs,
            'selectedLog' => $selectedLog,
        ]);
    }

    public function update(Request $request, ResidentLog $log): RedirectResponse
    {

        $request->validate([
            'departed_date' => 'required|date',
            'departed_time' => 'required',
            'returned_date' => 'nullable|date',
            'returned_time' => 'nullable',
            'notes' => 'required|string|min:5|max:500',
            'pass_slip_id' => 'nullable',
        ]);

        $editedBy = sprintf(
            '[Edited by %s %s | %s]',
            Auth::user()->nickname,
            Auth::user()->last_name,
            now()->format('M d, Y h:i A')
        );

        $log->update([
            'departed_at' => Carbon::parse($request->departed_date.' '.$request->departed_time),
            'returned_at' => $request->returned_date ? Carbon::parse($request->returned_date.' '.$request->returned_time) : null,
            'notes' => $request->notes."\n".$editedBy,
            'pass_slip_id' => $request->has('has_pass_slip') ? $log->pass_slip_id ?? 1 : null,
        ]);

        ActivityLog::create(['user_id' => Auth::id(), 'action_taken' => 'Resident Log Edited']);

        return redirect()
            ->route('logs.index')
            ->with('message', 'Resident log updated successfully.');
    }
}
