<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Dabalus',
                'first_name' => 'Nicole',
                'middle_name' => 'de Marie',
                'nickname' => 'Sister Nicole',
                'birthdate' => '1990-01-10',
                'user_type' => 'Admin',
                'phone_number' => null,
                'address' => 'SPUM',
                'password' => Hash::make('spum123'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'manager@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Andrada',
                'first_name' => 'Aneen',
                'middle_name' => null,
                'nickname' => 'Ms. Aneen',
                'birthdate' => '1990-05-16',
                'user_type' => 'Manager',
                'phone_number' => null,
                'address' => 'SPUM',
                'password' => Hash::make('spum123'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => '2023-1341@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Baltero',
                'first_name' => 'Alliyah Margarette Nicole',
                'middle_name' => 'Resurreccion',
                'nickname' => 'Nini',
                'birthdate' => '2005-03-19',
                'user_type' => 'Resident',
                'phone_number' => '09561568158',
                'address' => 'The Manila Residences Tower II, Taft Avenue, Malate, Manila',
                'password' => Hash::make('spum123'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'resident2@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Ngo',
                'first_name' => 'Marc Adriel',
                'middle_name' => 'Dela Cruz',
                'nickname' => 'Marc',
                'birthdate' => '2005-07-07',
                'user_type' => 'Resident',
                'phone_number' => null,
                'address' => 'Tondo',
                'password' => Hash::make('spum123'),
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'resident3@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Andrada',
                'first_name' => 'Alleah Mai',
                'middle_name' => null,
                'nickname' => 'Alleah',
                'birthdate' => '2005-05-20',
                'user_type' => 'Resident',
                'phone_number' => null,
                'address' => 'Ma. Orosa Street',
                'password' => Hash::make('spum123'),
            ]
        );
    }
}
