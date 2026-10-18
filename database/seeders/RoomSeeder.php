<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::firstOrCreate([
            'room_image' => 'images/rooms/lb101.jpg',
            'room_number' => '101',
            'dorm_name' => 'Le Berceau',
            'capacity' => 1,
        ]);

        Room::firstOrCreate([
            'room_image' => 'images/rooms/lb201.jpg',
            'room_number' => '201',
            'dorm_name' => 'Le Berceau',
            'capacity' => 2,
        ]);

        Room::firstOrCreate([
            'room_image' => 'images/rooms/mp102.jpg',
            'room_number' => '102',
            'dorm_name' => 'Maison Paul',
            'capacity' => 1,
        ]);

        Room::firstOrCreate([
            'room_image' => 'images/rooms/mp103.jpg',
            'room_number' => '103',
            'dorm_name' => 'Maison Paul',
            'capacity' => 2,
        ]);
    }
}
