<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'middlename' => fake()->firstName(),
            'nickname' => fake()->userName(),
            'birthdate' => fake()->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
            'user_type' => fake()->randomElement(['Student', 'Employee']),
            'address' => fake()->address(),
            'cellphone' => fake()->numerify('09#########'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'accommodation_type' => fake()->randomElement(['8_in_room', '4_in_room', '3_in_room', '2_in_room']),
            'payment_schedule' => fake()->randomElement(['full_payment', '2_equal_payments', '3_equal_payments', '4_equal_payments']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
