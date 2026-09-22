<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string|null $middlename
 * @property string|null $nickname
 * @property Carbon|null $birthdate
 * @property string $user_type
 * @property string|null $address
 * @property string|null $cellphone
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $accommodation_type
 * @property string|null $payment_schedule
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'lastname',
    'firstname',
    'middlename',
    'nickname',
    'birthdate',
    'user_type',
    'address',
    'cellphone',
    'email',
    'password',
    'accommodation_type',
    'payment_schedule',
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

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Get the user's initials based on their first and last name
     */
    public function initials(): string
    {
        $fullName = $this->firstname.' '.$this->middlename.' '.$this->lastname;
        $initials = Str::initials($fullName, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    public function isAdmin(): bool
    {
        return in_array($this->user_type, ['Admin', 'Manager']);
    }

    public function isDormer(): bool
    {
        return in_array($this->user_type, ['Student', 'Employee']);
    }
}
