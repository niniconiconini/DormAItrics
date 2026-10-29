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
            'room_image' => '/images/rooms/lb102.png',
            'room_number' => '102',
            'dorm_name' => 'Le Berceau',
            'capacity' => 2,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/lb103.jpg',
            'room_number' => '103',
            'dorm_name' => 'Le Berceau',
            'capacity' => 3,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/lb104.jpg',
            'room_number' => '104',
            'dorm_name' => 'Le Berceau',
            'capacity' => 4,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/lb108.jpg',
            'room_number' => '108',
            'dorm_name' => 'Le Berceau',
            'capacity' => 8,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/mp101.jpg',
            'room_number' => '101',
            'dorm_name' => 'Maison Paul',
            'capacity' => 1,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/mp102.jpg',
            'room_number' => '102',
            'dorm_name' => 'Maison Paul',
            'capacity' => 2,
        ]);

        Room::firstOrCreate([
            'room_image' => '/images/rooms/dt104.jpg',
            'room_number' => '104',
            'dorm_name' => 'Dorm 2',
            'capacity' => 4,
        ]);
    }
}
