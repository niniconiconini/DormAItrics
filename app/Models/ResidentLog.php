<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'resident_id',
    'departed_at',
    'returned_at',
    'pass_slip_id',
    'notes',
    'time_out_approver', // for guard in charge
    'time_in_approver', // for guard in charge
])]

class ResidentLog extends Model
{
    protected $casts = [
        'departed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Resident, $this>
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * @return BelongsTo<PassSlip, $this>
     */
    public function passSlip(): BelongsTo
    {
        return $this->belongsTo(PassSlip::class);
    }

    // for guard
    /**
     * @return BelongsTo<User, $this>
     */
    public function timeOutApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'time_out_approver');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function timeInApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'time_in_approver');
    }
}
