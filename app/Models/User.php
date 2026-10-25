<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $nickname
 * @property Carbon $birthdate
 * @property string $user_type
 * @property string|null $address
 * @property string|null $phone_number
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'last_name',
    'first_name',
    'middle_name',
    'nickname',
    'birthdate',
    'user_type',
    'address',
    'phone_number',
    'email',
    'password',
    'profile_picture',
    'status',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date', // Casts birthdate to a Carbon date instance
        ];
    }

    /**
     * @return HasMany<Announcement, $this>
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Get the user's initials based on their first and last name
     */
    public function initials(): string
    {
        $fullName = $this->first_name.' '.$this->middle_name.' '.$this->last_name;
        $initials = Str::initials($fullName, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    public function isAdmin(): bool
    {
        return in_array($this->user_type, ['Admin', 'Manager']);
    }

    public function isResident(): bool
    {
        return $this->user_type === 'Resident';
    }

    /**
     * @return HasOne<Resident, $this>
     */
    public function resident(): HasOne
    {
        return $this->hasOne(Resident::class);
    }

    /**
     * @return HasMany<ActivityLog, $this>
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * @return HasMany<PassSlip, $this>
     */
    public function approvedPassSlips(): HasMany
    {
        return $this->hasMany(
            PassSlip::class,
            'approved_by_user_id'
        );
    }
}
