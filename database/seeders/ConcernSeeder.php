<?php

namespace Database\Seeders;

use App\Models\Concern;
use Illuminate\Database\Seeder;

class ConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Broken Light',
            'message' => 'There is no light in Room 101.',
        ]);
    }
}
