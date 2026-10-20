<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'resident_id',
    'approved_by_user_id',
    'purpose',
    'requested_date_out',
    'requested_date_in',
    'requested_time_out',
    'requested_time_in',
    'status',
])]

class PassSlip extends Model
{
    /**
     * @return BelongsTo<Resident, $this>
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function returnAt(): Carbon
    {
        return Carbon::parse($this->requested_date_in.' '.$this->requested_time_in);
    }

    public function displayStatus(): string
    {
        if (in_array($this->status, ['Pending', 'Approved']) && $this->returnAt()->isPast()) {
            return 'Expired';
        }

        return match ($this->status) {
            'Pending' => 'For approval',
            'Rejected' => 'Denied',
            default => $this->status,
        };
    }

    // css class for the status badge
    public function statusClass(): string
    {
        return match ($this->displayStatus()) {
            'For approval' => 'status-pending',
            'Approved' => 'status-approved',
            'Denied' => 'status-denied',
            'Cancelled' => 'status-cancelled',
            default => 'status-expired',
        };
    }
}