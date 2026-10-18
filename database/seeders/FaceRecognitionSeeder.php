<?php

namespace Database\Seeders;

use App\Models\FaceRecognition;
use Illuminate\Database\Seeder;

class FaceRecognitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FaceRecognition::firstOrCreate([
            'resident_id' => 1,
        ], [
            'face_reference' => 'resident_1.jpg',
        ]);
    }
}
