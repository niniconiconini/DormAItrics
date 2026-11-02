<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

#[Fillable([
    'resident_id',
    'review_rating',
    'title',
    'message',
])]

class Review extends Model
{
    /**
     * @return BelongsTo<Resident, $this>
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * @return HasOneThrough<User, Resident, $this>
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Resident::class, 'id', 'id', 'resident_id', 'user_id');
    }

    public function reviewerName(): string
    {
        return collect([$this->user?->first_name, $this->user?->last_name])->filter()->implode(' ');
    }
}
