<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'resident_id',
    'departed_at',
    'returned_at',
])]
class ResidentLog extends Model
{
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
