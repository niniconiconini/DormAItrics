<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id',
    'room_id',
    'resident_type',
    'accommodation_type',
    'payment_schedule',
    'check_in_date',
    'check_out_date',
    'status',
])]
class Resident extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function faceRecognition(): HasOne
    {
        return $this->hasOne(FaceRecognition::class);
    }

    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(ResidentLog::class);
    }

    public function passSlips(): HasMany
    {
        return $this->hasMany(PassSlip::class);
    }

    public function concerns(): HasMany
    {
        return $this->hasMany(Concern::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
