<?php

namespace App\Http\Controllers;

use App\Models\PassSlip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PassSlipMgmtController extends Controller
{
    public function index(): View
    {
        /** @var Collection<int, PassSlip> $passSlips */
        $passSlips = PassSlip::with(['user', 'approver'])->latest()->get();

        // slips still waiting for a decision, oldest first
        $forApproval = $passSlips
            ->filter(fn ($slip) => $slip->displayStatus() === 'For approval')
            ->sortBy('created_at')
            ->values();

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

        return redirect()->route('slips-mgmt')->with('success', $message);
    }
}
