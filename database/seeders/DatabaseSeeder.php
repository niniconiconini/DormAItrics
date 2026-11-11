<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoomSeeder::class,
            UserSeeder::class,
            ResidentSeeder::class,
            // AnnouncementSeeder::class,
            // ActivityLogSeeder::class,
            // ReviewSeeder::class,
            // ConcernSeeder::class,
            // FaceRecognitionSeeder::class,
            // ResidentLogSeeder::class,
            PassSlipSeeder::class,
        ]);
    }
}
