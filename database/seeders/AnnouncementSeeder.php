<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Welcome Dormers',
            'message' => 'Welcome to the Dormitory of St. Paul University Manila.',
        ]);
    }
}
