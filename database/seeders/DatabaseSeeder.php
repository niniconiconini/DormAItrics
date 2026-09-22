<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'resurreccion.nini@gmail.com'],
            [
                'lastname' => 'Resurreccion',
                'firstname' => 'Nini',
                'nickname' => 'Nini',
                'user_type' => 'Student',
                'address' => 'Default Address',
                'cellphone' => '09123456789',
                'password' => Hash::make('spum123'),
                'accommodation_type' => '2_in_room',
                'payment_schedule' => '4_equal_payments',
            ],
        );
    }
}
