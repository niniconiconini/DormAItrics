<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::firstOrCreate([
            'resident_id' => 1,
        ], [
            'review_rating' => 5,
            'message' => 'The Dormitory is clean and well maintained.',
        ]);
    }
}
