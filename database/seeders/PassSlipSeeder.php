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
            'approved_by_user_id' => 2,
            'requested_date_out' => '2026-10-21',
            'requested_date_in' => '2026-10-21',
            'requested_time_out' => '16:00:00',
            'requested_time_in' => '18:00:00',
            'status' => 'Approved',
        ]);
    }
}
