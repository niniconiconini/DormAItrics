<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'resident_id',
    'review_rating',
    'message',
])]

class Review extends Model
{
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
