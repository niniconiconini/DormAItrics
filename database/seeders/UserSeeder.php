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
                'email' => 'resident1@spumanila.edu.ph',
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

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident3@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Wayne',
        //         'first_name' => 'Bruce',
        //         'middle_name' => 'Thomas',
        //         'nickname' => 'Batman',
        //         'birthdate' => '1993-02-19',
        //         'gender' => 'Male',
        //         'phone_number' => null,
        //         'address' => 'Gotham',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Inactive',
        //         'profile_picture' => '/images/users/user_7.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient3@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Kent',
        //         'first_name' => 'Clark',
        //         'middle_name' => 'Joseh',
        //         'nickname' => 'Superman',
        //         'birthdate' => '1996-06-18',
        //         'gender' => 'Male',
        //         'phone_number' => null,
        //         'address' => 'Metropolis',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Inactive',
        //         'profile_picture' => '/images/users/user_8.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident3@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Stark',
        //         'first_name' => 'Anthony',
        //         'middle_name' => 'Edward',
        //         'nickname' => 'Iron Man',
        //         'birthdate' => '1993-05-29',
        //         'gender' => 'Male',
        //         'phone_number' => null,
        //         'address' => 'New York',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Inactive',
        //         'profile_picture' => '/images/users/user_9.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient3@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Parker',
        //         'first_name' => 'Peter',
        //         'middle_name' => 'Benjamin',
        //         'nickname' => 'Spider-Man',
        //         'birthdate' => '2001-09-10',
        //         'gender' => 'Male',
        //         'phone_number' => null,
        //         'address' => 'Queens',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Inactive',
        //         'profile_picture' => '/images/users/user_10.png',
        //     ]
        // );

        // // New Seeds
        // User::firstOrCreate(
        //     [
        //         'email' => 'resident4@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Santos',
        //         'first_name' => 'Maria',
        //         'middle_name' => 'Clara',
        //         'nickname' => 'Clara',
        //         'birthdate' => '2004-01-15',
        //         'gender' => 'Female',
        //         'phone_number' => '09171234567',
        //         'address' => 'Ermita, Manila',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_11.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient4@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Reyes',
        //         'first_name' => 'Juan',
        //         'middle_name' => 'Carlos',
        //         'nickname' => 'JC',
        //         'birthdate' => '2003-11-22',
        //         'gender' => 'Male',
        //         'phone_number' => '09189876543',
        //         'address' => 'Paco, Manila',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_12.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident5@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Cruz',
        //         'first_name' => 'Samantha',
        //         'middle_name' => 'Joy',
        //         'nickname' => 'Sam',
        //         'birthdate' => '2005-08-30',
        //         'gender' => 'Female',
        //         'phone_number' => '09223334444',
        //         'address' => 'Makati City',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_13.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient5@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Garcia',
        //         'first_name' => 'Gabriel',
        //         'middle_name' => 'Luis',
        //         'nickname' => 'Gaby',
        //         'birthdate' => '2004-04-12',
        //         'gender' => 'Male',
        //         'phone_number' => '09995556666',
        //         'address' => 'Quezon City',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_14.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident6@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Mendoza',
        //         'first_name' => 'Beatrice',
        //         'middle_name' => 'Anne',
        //         'nickname' => 'Bea',
        //         'birthdate' => '2005-12-05',
        //         'gender' => 'Female',
        //         'phone_number' => '09157778888',
        //         'address' => 'Pasay City',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_15.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient6@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Villanueva',
        //         'first_name' => 'Christian',
        //         'middle_name' => 'Paul',
        //         'nickname' => 'Chris',
        //         'birthdate' => '2003-02-28',
        //         'gender' => 'Male',
        //         'phone_number' => '09081112222',
        //         'address' => 'Mandaluyong City',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_16.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident7@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Aquino',
        //         'first_name' => 'Denise',
        //         'middle_name' => 'Marie',
        //         'nickname' => 'Den',
        //         'birthdate' => '2004-06-14',
        //         'gender' => 'Female',
        //         'phone_number' => '09171112233',
        //         'address' => 'Manila',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_17.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient7@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Bautista',
        //         'first_name' => 'Nathaniel',
        //         'middle_name' => 'John',
        //         'nickname' => 'Nate',
        //         'birthdate' => '2003-09-19',
        //         'gender' => 'Male',
        //         'phone_number' => '09182223344',
        //         'address' => 'San Juan',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_18.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident8@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Castillo',
        //         'first_name' => 'Angela',
        //         'middle_name' => 'Mae',
        //         'nickname' => 'Angie',
        //         'birthdate' => '2005-02-11',
        //         'gender' => 'Female',
        //         'phone_number' => '09193334455',
        //         'address' => 'Caloocan',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_19.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient8@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Dizon',
        //         'first_name' => 'Lucas',
        //         'middle_name' => 'Miguel',
        //         'nickname' => 'Luke',
        //         'birthdate' => '2004-10-03',
        //         'gender' => 'Male',
        //         'phone_number' => '09204445566',
        //         'address' => 'Valenzuela',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_20.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident9@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Espiritu',
        //         'first_name' => 'Camille',
        //         'middle_name' => 'Joy',
        //         'nickname' => 'Cami',
        //         'birthdate' => '2005-07-25',
        //         'gender' => 'Female',
        //         'phone_number' => '09215556677',
        //         'address' => 'Malabon',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_21.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient9@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Flores',
        //         'first_name' => 'Mateo',
        //         'middle_name' => 'Gabriel',
        //         'nickname' => 'Matt',
        //         'birthdate' => '2003-12-12',
        //         'gender' => 'Male',
        //         'phone_number' => '09226667788',
        //         'address' => 'Navotas',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_22.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident10@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Gonzales',
        //         'first_name' => 'Sophia',
        //         'middle_name' => 'Grace',
        //         'nickname' => 'Sophie',
        //         'birthdate' => '2004-03-30',
        //         'gender' => 'Female',
        //         'phone_number' => '09237778899',
        //         'address' => 'Taguig',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_23.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient10@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Hernandez',
        //         'first_name' => 'Daniel',
        //         'middle_name' => 'James',
        //         'nickname' => 'Dan',
        //         'birthdate' => '2003-05-18',
        //         'gender' => 'Male',
        //         'phone_number' => '09248889900',
        //         'address' => 'Pasig',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_24.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident11@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Ignacio',
        //         'first_name' => 'Chloe',
        //         'middle_name' => 'Faith',
        //         'nickname' => 'Clo',
        //         'birthdate' => '2005-09-08',
        //         'gender' => 'Female',
        //         'phone_number' => '09259990011',
        //         'address' => 'Marikina',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_25.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient11@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Javier',
        //         'first_name' => 'Sebastian',
        //         'middle_name' => 'Cole',
        //         'nickname' => 'Seb',
        //         'birthdate' => '2004-11-01',
        //         'gender' => 'Male',
        //         'phone_number' => '09260001122',
        //         'address' => 'Parañaque',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_26.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident12@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Lim',
        //         'first_name' => 'Zoe',
        //         'middle_name' => 'Victoria',
        //         'nickname' => 'Zoe',
        //         'birthdate' => '2005-01-20',
        //         'gender' => 'Female',
        //         'phone_number' => '09271112233',
        //         'address' => 'Las Piñas',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_27.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient12@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Mercado',
        //         'first_name' => 'Adrian',
        //         'middle_name' => 'Scott',
        //         'nickname' => 'Adi',
        //         'birthdate' => '2003-08-15',
        //         'gender' => 'Male',
        //         'phone_number' => '09282223344',
        //         'address' => 'Muntinlupa',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_28.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'resident13@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Navarro',
        //         'first_name' => 'Hannah',
        //         'middle_name' => 'Belle',
        //         'nickname' => 'Han',
        //         'birthdate' => '2004-06-22',
        //         'gender' => 'Female',
        //         'phone_number' => '09293334455',
        //         'address' => 'Pateros',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_29.png',
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'transient13@spumanila.edu.ph',
        //     ],
        //     [
        //         'last_name' => 'Pascual',
        //         'first_name' => 'Liam',
        //         'middle_name' => 'Alexander',
        //         'nickname' => 'Liam',
        //         'birthdate' => '2003-03-10',
        //         'gender' => 'Male',
        //         'phone_number' => '09304445566',
        //         'address' => 'San Juan',
        //         'password' => Hash::make('spum123'),
        //         'user_type' => 'Resident',
        //         'status' => 'Active',
        //         'profile_picture' => '/images/users/user_30.png',
        //     ]
        // );
    }
}
