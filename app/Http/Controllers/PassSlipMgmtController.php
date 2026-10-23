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
            ->oldest('id')
            ->paginate(5, ['*'], 'approval_page')
            ->withQueryString()
            ->fragment('for-approval');

        if ($forApproval->isEmpty() && $forApproval->currentPage() > 1) {
            return redirect($forApproval->url($forApproval->lastPage()));
        }

        $passSlips = PassSlip::with(['user', 'approver'])
            ->latest('id')
            ->paginate(5, ['*'], 'all_page')
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

    // wipes every pass slip record from the database
    public function destroyAll(): RedirectResponse
    {
        PassSlip::query()->delete();

        return redirect()->route('slips-mgmt')->with('success', 'All pass slips have been deleted.');
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
