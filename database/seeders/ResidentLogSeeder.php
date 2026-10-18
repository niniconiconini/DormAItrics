<?php

namespace Database\Seeders;

use App\Models\ResidentLog;
use Illuminate\Database\Seeder;

class ResidentLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResidentLog::firstOrCreate([
            'resident_id' => 1,
        ], [
            'departed_at' => '2026-10-01 04:00:00',
            'returned_at' => '2026-10-01 08:00:00',
        ]);
    }
}
