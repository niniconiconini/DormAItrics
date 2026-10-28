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
        // ============================================10 pass slips

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 2,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);
        // ============================================20 pass slips

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 3,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);
        // ============================================30 pass slips

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Lunch',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-01',
            'requested_date_in' => '2026-11-01',
            'requested_time_out' => '12:00:00',
            'requested_time_in' => '13:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Mall',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-03',
            'requested_date_in' => '2026-11-03',
            'requested_time_out' => '14:00:00',
            'requested_time_in' => '17:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Doctor',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-05',
            'requested_date_in' => '2026-11-05',
            'requested_time_out' => '09:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Family Visit',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-07',
            'requested_date_in' => '2026-11-07',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Groceries',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-08',
            'requested_date_in' => '2026-11-08',
            'requested_time_out' => '10:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Rejected',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Org Meeting',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-11-09',
            'requested_date_in' => '2026-11-09',
            'requested_time_out' => '13:00:00',
            'requested_time_in' => '16:00:00',
            'status' => 'Cancelled',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Dinner',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-10',
            'requested_date_in' => '2026-11-10',
            'requested_time_out' => '18:00:00',
            'requested_time_in' => '20:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Church',
            'approved_by_user_id' => null,
            'requested_date_out' => '2026-11-11',
            'requested_date_in' => '2026-11-11',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '11:00:00',
            'status' => 'Pending',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-06-15',
            'requested_date_in' => '2025-06-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);

        PassSlip::firstOrCreate([
            'resident_id' => 4,
            'purpose' => 'Very Very Old Test Slip',
            'approved_by_user_id' => 2,
            'requested_date_out' => '2025-01-15',
            'requested_date_in' => '2025-01-15',
            'requested_time_out' => '08:00:00',
            'requested_time_in' => '12:00:00',
            'status' => 'Approved',
        ]);
        // ============================================40 pass slips

        // ============================================41-100 pass slips
        for ($i = 41; $i <= 100; $i++) {
            $residentId = match (true) {
                $i <= 55 => 1,
                $i <= 70 => 2,
                $i <= 85 => 3,
                default => 4,
            };

            $statuses = [
                'Pending',
                'Approved',
                'Rejected',
                'Cancelled',
            ];

            $status = $statuses[$i % 4];

            PassSlip::firstOrCreate([
                'resident_id' => $residentId,
                'purpose' => "Test Slip {$i}",
                'approved_by_user_id' => in_array($status, ['Approved', 'Rejected']) ? 2 : null,
                'requested_date_out' => '2026-12-'.str_pad(strval(rand(1, 28)), 2, '0', STR_PAD_LEFT),
                'requested_date_in' => '2026-12-'.str_pad(strval(rand(1, 28)), 2, '0', STR_PAD_LEFT),
                'requested_time_out' => '08:00:00',
                'requested_time_in' => '12:00:00',
                'status' => $status,
            ]);
        }
    }
}
