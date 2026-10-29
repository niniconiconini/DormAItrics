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
            'subject' => 'Broken Light #1',
            'message' => 'There is no light in the hallway.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Leaking Faucet #2',
            'message' => 'The bathroom sink is constantly dripping.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'AC Unit Not Cooling #3',
            'message' => 'The air conditioning unit is only blowing warm air.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Clogged Drain #4',
            'message' => 'Water is pooling in the shower drain.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Wi-Fi Connection Issues #5',
            'message' => 'The internet connection drops frequently in the evening.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Door Knob Loose #6',
            'message' => 'The main door knob is wobbling and feels unstable.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Window Latch Broken #7',
            'message' => 'The bedroom window cannot be securely locked shut.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'No Hot Water #8',
            'message' => 'The shower is only producing cold water today.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Pest Control Request #9',
            'message' => 'Noticed insects near the kitchen area.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Noise Complaint #10',
            'message' => 'Excessive noise coming from the adjacent room late at night.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Ceiling Leak #11',
            'message' => 'Water dripping from the ceiling during heavy rain.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Power Outlet Spark #12',
            'message' => 'The outlet near the study desk emitted a small spark.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Cabinet Door Off Hinge #13',
            'message' => 'The kitchen cabinet door completely detached.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Bed Frame Squeaking #14',
            'message' => 'The bed frame makes loud noises with minimal movement.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Exhaust Fan Broken #15',
            'message' => 'The bathroom ventilation fan is not turning on.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Main Gate Key Card Not Working #16',
            'message' => 'RFID tag fails to register at the entrance turnstile.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Elevator Delay #17',
            'message' => 'Elevator B is taking a very long time on the 4th floor.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Garbage Bin Overflow #18',
            'message' => 'Hallway trash disposal bin needs collection.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Study Area Lights #19',
            'message' => 'Two fluorescent tubes are flickering in the shared study room.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Water Pressure Low #20',
            'message' => 'Shower water pressure is extremely weak this morning.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Broken Blind Slat #21',
            'message' => 'Vertical window blind snapped off.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Shared Microwave Issue #22',
            'message' => 'Pantry microwave turntable plate is cracked.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Laundry Area Dryer #23',
            'message' => 'Dryer machine #3 is not heating up clothes properly.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Fire Alarm Sensor Beeping #24',
            'message' => 'Smoke detector is intermittently chirping low battery warning.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Desks Surface Scratch #25',
            'message' => 'Deep scratch found on the study table upon move-in inspection.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Bicycle Rack Damaged #26',
            'message' => 'One of the slots in the outdoor bike rack is bent.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Vending Machine Jam #27',
            'message' => 'Snack machine swallowed coins without dispensing item.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Bathroom Tile Grout #28',
            'message' => 'Mold buildup observed along shower wall tiles.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Hallway Mirror Loose #29',
            'message' => 'The wall-mounted mirror near the elevator shakes slightly.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Study Chair Wheel Missing #30',
            'message' => 'One caster wheel is missing from the ergonomic desk chair.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Balcony Drain Blocked #31',
            'message' => 'Leaves clogging the exterior balcony drain grate.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Internet LAN Port Dead #32',
            'message' => 'Ethernet wall port in room 204 has no link light.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Water Dispenser Empty #33',
            'message' => 'Lobby hot and cold water station needs a replacement jug.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Pantry Sink Slow Drain #34',
            'message' => 'Kitchenette sink water drains very sluggishly.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Locker Cam Lock Jammed #35',
            'message' => 'Package locker #12 key is stuck in the cylinder.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Emergency Exit Sign Out #36',
            'message' => 'Green exit sign bulb is burned out on the 3rd floor.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Gym Equipment Cable #37',
            'message' => 'Pulley cable on the multi-gym station feels frayed.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Shoe Rack Clutter #38',
            'message' => 'Overflowing footwear in common mudroom entry.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Mailbox Compartment Key #39',
            'message' => 'Mail slot latch is difficult to turn open.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Printer Paper Jam #40',
            'message' => 'Lobby printing station is displaying a persistent feed error.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Roof Deck Access Door #41',
            'message' => 'Steel door latch sticks during windy afternoons.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Stairwell Light Sensor #42',
            'message' => 'Motion sensor light turns off too quickly on level 2.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Visitor Log Tablet #43',
            'message' => 'Front desk check-in iPad battery is drained.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Ironing Board Cover #44',
            'message' => 'Shared ironing board surface fabric is scorched.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Parking Slot Marker #45',
            'message' => 'Painted number line on slot 15 is fading away.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 2,
            'subject' => 'Window Screen Tear #46',
            'message' => 'Small mesh tear on the insect screen.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 5,
            'subject' => 'Lobby Air Freshener #47',
            'message' => 'Dispenser unit needs a refill cartridge.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 1,
            'subject' => 'Study Room Reservation App #48',
            'message' => 'Calendar slot showing conflicting booking error.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 3,
            'subject' => 'Fire Extinguisher Check #49',
            'message' => 'Inspection tag needs updating near fire exit B.',
        ]);

        Concern::firstOrCreate([
            'resident_id' => 4,
            'subject' => 'Main Entrance Mat #50',
            'message' => 'Rubber welcome mat is curling up causing a trip hazard.',
        ]);
    }
}
