<?php

namespace Database\Seeders;

use App\Models\PassSlip;
use Illuminate\Database\Seeder;

class PassSlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);


        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 1,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);
    }
}
