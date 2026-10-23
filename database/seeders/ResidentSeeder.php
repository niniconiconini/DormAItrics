<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resident::firstOrCreate([
            'user_id' => 3,
        ], [
            'room_id' => 1,
            'resident_type' => 'Employee',
            'accommodation_type' => 'Resident',
            'payment_schedule' => 'Full Payment',
            'check_in_date' => '2026-09-10',
            'status' => 'Active',
        ]);

        Resident::firstOrCreate([
            'user_id' => 4,
        ], [
            'room_id' => 2,
            'resident_type' => 'Student',
            'accommodation_type' => 'Resident',
            'payment_schedule' => 'Full Payment',
            'check_in_date' => '2026-09-10',
            'status' => 'Active',
        ]);

        Resident::firstOrCreate([
            'user_id' => 5,
        ], [
            'room_id' => 3,
            'resident_type' => 'Student',
            'accommodation_type' => 'Transient',
            'payment_schedule' => 'Full Payment',
            'check_in_date' => '2026-09-10',
            'status' => 'Inactive',
        ]);
    }
}
