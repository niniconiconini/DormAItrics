<?php

namespace App\Http\Controllers;

use App\Models\PassSlip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PassSlipMgmtController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $forApproval = PassSlip::with('user')
            ->forApproval()
            ->whereNull('cleared_at')
            ->oldest('id')
            ->paginate(5, ['*'], 'approval_page')
            ->withQueryString()
            ->fragment('for-approval');

        if ($forApproval->isEmpty() && $forApproval->currentPage() > 1) {
            return redirect($forApproval->url($forApproval->lastPage()));
        }

        $passSlips = PassSlip::with(['user', 'approver'])
            ->whereNull('cleared_at')
            ->latest('id')
            ->paginate(20, ['*'], 'all_page')
            ->withQueryString()
            ->fragment('all-slips');

        return view('slips-mgmt', compact('passSlips', 'forApproval'));
    }

    public function approve(PassSlip $passSlip): RedirectResponse
    {
        return $this->decide($passSlip, 'Approved', 'Pass slip approved.');
    }

    public function deny(PassSlip $passSlip): RedirectResponse
    {
        return $this->decide($passSlip, 'Rejected', 'Pass slip denied.');
    }

    // Clears pass slips whose trip ended two months ago. The records stay in the database
    public function destroyAll(): RedirectResponse
    {
        $cleared = PassSlip::query()
            ->whereNull('cleared_at')
            ->whereRaw('TIMESTAMP(requested_date_in, requested_time_in) <= ?', [now()->subMonths(2)->toDateTimeString()])
            ->toBase()
            ->update(['cleared_at' => now()]);

        if ($cleared === 0) {
            return back()->with('error', 'There are no pass slips whose trip ended two months ago or earlier.');
        }

        return redirect()->route('slips-mgmt')->with('success', "Cleared {$cleared} pass slip(s) whose trip ended two months ago or earlier.");
    }

    // saves the decision and who made it
    private function decide(PassSlip $passSlip, string $status, string $message): RedirectResponse
    {
        if ($passSlip->displayStatus() !== 'For approval') {
            return back()->with('error', 'This pass slip can no longer be approved or denied.');
        }

        $passSlip->update([
            'status' => $status,
            'approved_by_user_id' => Auth::id(),
        ]);

        return back()->with('success', $message);
    }
}
