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
                'gender' => 'Female',
                'birthdate' => '1990-01-10',
                'phone_number' => null,
                'address' => 'SPUM',
                'password' => Hash::make('spum123'),
                'user_type' => 'Admin',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_1.png',
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
                'gender' => 'Female',
                'birthdate' => '1990-05-16',
                'phone_number' => null,
                'address' => 'SPUM',
                'password' => Hash::make('spum123'),
                'user_type' => 'Manager',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_2.png',
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
                'gender' => 'Female',
                'phone_number' => '09561568158',
                'address' => 'The Manila Residences Tower II, Taft Avenue, Malate, Manila',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_3.png',
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
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'Tondo',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_4.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'transient1@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Andrada',
                'first_name' => 'Alleah Mai',
                'middle_name' => null,
                'nickname' => 'Alleah',
                'birthdate' => '2005-05-20',
                'gender' => 'Female',
                'phone_number' => null,
                'address' => 'Ma. Orosa Street',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_5.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'transient2@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Domingo',
                'first_name' => 'Juaqin Aiñigo',
                'middle_name' => 'De Jesus',
                'nickname' => 'Jaja',
                'birthdate' => '2003-09-04',
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'Sta. Ana',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Active',
                'profile_picture' => '/images/users/user_6.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'admin2@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Wayne',
                'first_name' => 'Bruce',
                'middle_name' => 'Thomas',
                'nickname' => 'Batman',
                'birthdate' => '1993-02-19',
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'Gotham',
                'password' => Hash::make('spum123'),
                'user_type' => 'Admin',
                'status' => 'Inactive',
                'profile_picture' => '/images/users/user_7.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'manager2@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Kent',
                'first_name' => 'Clark',
                'middle_name' => 'Joseh',
                'nickname' => 'Superman',
                'birthdate' => '1996-06-18',
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'Metropolis',
                'password' => Hash::make('spum123'),
                'user_type' => 'Manager',
                'status' => 'Inactive',
                'profile_picture' => '/images/users/user_8.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'resident3@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Stark',
                'first_name' => 'Anthony',
                'middle_name' => 'Edward',
                'nickname' => 'Iron Man',
                'birthdate' => '1993-05-29',
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'New York',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Inactive',
                'profile_picture' => '/images/users/user_9.png',
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'transient3@spumanila.edu.ph',
            ],
            [
                'last_name' => 'Parker',
                'first_name' => 'Peter',
                'middle_name' => 'Benjamin',
                'nickname' => 'Spider-man',
                'birthdate' => '2001-09-10',
                'gender' => 'Male',
                'phone_number' => null,
                'address' => 'Queens',
                'password' => Hash::make('spum123'),
                'user_type' => 'Resident',
                'status' => 'Inactive',
                'profile_picture' => '/images/users/user_10.png',
            ]
        );
    }
}
