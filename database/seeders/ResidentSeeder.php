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
            'check_out_date' => '2026-12-10',
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
            'check_out_date' => '2026-11-10',
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
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 6,
        ], [
            'room_id' => 2,
            'resident_type' => 'Employee',
            'accommodation_type' => 'Transient',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 9,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 10,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        // New Seeds
        Resident::firstOrCreate([
            'user_id' => 11,
        ], [
            'room_id' => 1,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 12,
        ], [
            'room_id' => 2,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 13,
        ], [
            'room_id' => 3,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 14,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 15,
        ], [
            'room_id' => 1,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 16,
        ], [
            'room_id' => 2,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 17,
        ], [
            'room_id' => 3,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 18,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 19,
        ], [
            'room_id' => 1,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 20,
        ], [
            'room_id' => 2,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 21,
        ], [
            'room_id' => 3,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 22,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 23,
        ], [
            'room_id' => 1,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 24,
        ], [
            'room_id' => 2,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 25,
        ], [
            'room_id' => 3,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 26,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 27,
        ], [
            'room_id' => 1,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Student',
            'payment_schedule' => 'Full Payment',
            'room_type' => '2 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 28,
        ], [
            'room_id' => 2,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 29,
        ], [
            'room_id' => 3,
            'accommodation_type' => 'Resident',
            'resident_type' => 'Employee',
            'payment_schedule' => 'Full Payment',
            'room_type' => '3 persons',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-12-10',
        ]);

        Resident::firstOrCreate([
            'user_id' => 30,
        ], [
            'room_id' => 4,
            'accommodation_type' => 'Transient',
            'resident_type' => 'Student',
            'payment_schedule' => 'Per Day',
            'room_type' => '1 person',
            'check_in_date' => '2026-09-10',
            'check_out_date' => '2026-11-10',
        ]);
    }
}