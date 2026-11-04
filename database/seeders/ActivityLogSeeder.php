<!-- ?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityLog::firstOrCreate([
            'user_id' => 1,
            'action_taken' => 'added a new dorm room',
        ]);
    }
} -->
