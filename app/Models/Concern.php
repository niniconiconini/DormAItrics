<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

#[Fillable([
    'resident_id',
    'subject',
    'message',
])]
class Concern extends Model
{
    /**
     * @return BelongsTo<Resident, $this>
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * the resident who posted the concern (concern -> resident -> user)
     *
     * @return HasOneThrough<User, Resident, $this>
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Resident::class, 'id', 'id', 'resident_id', 'user_id');
    }

    public function reporterName(): string
    {
        return collect([$this->user?->first_name, $this->user?->last_name])->filter()->implode(' ');
    }

    /**
     * the users who liked this concern
     *
     * @return BelongsToMany<User, $this>
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'concern_likes')->withTimestamps();
    }

    /**
     * replies, oldest first
     *
     * @return HasMany<ConcernReply, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ConcernReply::class)->withTrashed()->oldest();
    }
}
