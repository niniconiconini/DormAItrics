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
            'accommodation_type' => 'Resident',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 4,
        ], [
            'room_id' => 2,
            'resident_type' => 'Student',
            'accommodation_type' => 'Resident',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 5,
        ], [
            'room_id' => 3,
            'resident_type' => 'Student',
            'accommodation_type' => 'Transient',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-09-10',
        ]);
    }
}
