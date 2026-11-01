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

    // New Seeds
        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Monthly General Cleaning',
            'message' => 'Please be advised that general cleaning for all rooms and common areas is scheduled this Saturday morning.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Curfew Reminder',
            'message' => 'As a reminder, all residents must be inside the dormitory premises by 10:00 PM on weekdays.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Wi-Fi Maintenance Notice',
            'message' => 'Internet connectivity will experience temporary interruption tonight from 1:00 AM to 4:00 AM due to router upgrades.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Midterm Examination Quiet Hours',
            'message' => 'Strict quiet hours are now in effect 24/7 to support residents reviewing for upcoming examinations.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Water Service Interruption',
            'message' => 'Maynilad has announced an emergency service interruption in the Taft Avenue area. Please store adequate water supplies.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Pass Slip Policy Update',
            'message' => 'All overnight pass slip requests must now be submitted at least 24 hours prior to departure through the portal.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Lobby Visitor Guidelines',
            'message' => 'Visitors are only allowed in the ground floor receiving area and must leave their valid IDs at the security desk.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Fire Drill Simulation',
            'message' => 'A mandatory fire safety drill will be conducted this Friday at 3:00 PM. All residents are required to participate.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Dormitory Council Elections',
            'message' => 'Nominations for the new term dormitory student council representatives are now open. Check your emails for details.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Package Claiming Notice',
            'message' => 'Couriers have dropped off multiple deliveries at the front desk. Please claim your packages before 8:00 PM.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Air Conditioning Servicing',
            'message' => 'The maintenance team will begin checking and cleaning room air conditioning units starting on the 3rd floor.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Community Movie Night',
            'message' => 'Join us at the common lounge this Friday evening for a relaxing movie night and free popcorn!',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Lost and Found Items',
            'message' => 'Several umbrellas and tumblers were left in the study hall. Kindly claim them at the management office.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Energy Conservation Drive',
            'message' => 'Please remember to switch off lights, electric fans, and air conditioning units when leaving your rooms.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Holiday Schedule Advisory',
            'message' => 'The administrative office will operate on holiday hours next week in observance of the upcoming national holiday.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'New Laundry Room Guidelines',
            'message' => 'Please be courteous of your fellow residents by clearing out washed clothes from the laundry machines promptly.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Pest Control Treatment',
            'message' => 'Scheduled pest control fogging will take place across all building floors this coming Sunday afternoon.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Study Room Reservation',
            'message' => 'Group study rooms on the second floor can now be reserved online via the DormAItrics scheduling tab.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Parking Space Rules',
            'message' => 'Unauthorized vehicles parked in designated resident slots will be clamped effective immediately.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Health and Wellness Check',
            'message' => 'The university clinic is offering voluntary wellness checks and flu vaccinations at the ground floor clinic.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Trash Disposal Reminder',
            'message' => 'Please segregate your garbage properly and dispose of them in the main hallway utility bins.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Elevator Maintenance Schedule',
            'message' => 'Elevator number 2 will undergo routine monthly servicing this Wednesday morning. Please use elevator 1.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Sports Fest Registration',
            'message' => 'Sign up for the upcoming inter-floor basketball and badminton tournaments at the front desk.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Kitchenette Etiquette',
            'message' => 'Kindly wash your utensils and clean up counter spaces immediately after preparing meals in the pantry.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Security Gate Scanning Update',
            'message' => 'Facial recognition scanners at the main entrance have been updated for faster and more reliable access.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Donation Drive Initiative',
            'message' => 'We are collecting pre-loved clothes and books for our community outreach program. Drop boxes are in the lobby.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Typhoon Signal Precaution',
            'message' => 'Due to weather warnings, please ensure your windows are tightly latched and loose items on ledges are stored.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Intramurals Week Schedule',
            'message' => 'Dormitory curfew will be adjusted by one hour during the university intramurals celebration week.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Monthly Dorm Meeting',
            'message' => 'A mandatory meeting for all resident floor representatives is set for Thursday at 7:00 PM.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'CCTV Upgrades Completed',
            'message' => 'Additional security cameras have been installed across all corridor hallways for enhanced safety.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Board Game Night',
            'message' => 'Unwind from your school projects with board games and snacks at the recreation room this Friday.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Water Dispenser Refill',
            'message' => 'New filtered water gallon replacements have been installed in all floor pantries.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Maintenance Request Feedback',
            'message' => 'Please rate your recent repair ticket experiences through the resident web portal system.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Alumni Homecoming Visit',
            'message' => 'Some former dormers will be visiting the campus this weekend. Let us give them a warm Paulinian welcome!',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Power Interruption Advisory',
            'message' => 'Meralco scheduled a brief power transformer check in our sector this coming Sunday dawn.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Exam Week Care Packages',
            'message' => 'Special care packages prepared by the management will be distributed to all resident rooms tomorrow.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Balcony Safety Regulations',
            'message' => 'Hanging clothes or placing heavy items on exterior balcony railings is strictly prohibited.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Lighting Fixture Inspection',
            'message' => 'Facility staff will check hallway and room emergency light batteries this coming Tuesday afternoon.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Guest Policy Reminder',
            'message' => 'Non-resident guests are not permitted inside the dormitory bedroom floors after 9:00 PM.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Recycling Program Launch',
            'message' => 'We are rolling out a new plastic and paper recycling program. Look out for labeled bins in the lobby.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Final Examination Stress Relief',
            'message' => 'A short yoga and breathing session will be held at the multi-purpose hall this Saturday morning.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'New Printer Station Available',
            'message' => 'A self-service student printing kiosk has been set up near the ground floor study lounge.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Locksmith Service Notice',
            'message' => 'If you lost your room key, please coordinate with the front desk guard for authorized duplication.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Christmas Party Announcement',
            'message' => 'Save the date for our annual dormitory Christmas celebration and gift-giving event next month!',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Summer Dormitory Reservation',
            'message' => 'Applications for summer term stay and transient occupancy are now open at the management portal.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'Bulky Item Delivery Notice',
            'message' => 'Please inform the front office in advance if you are expecting large furniture or appliance deliveries.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 2,
            'title' => 'Lost ID Card Replacement',
            'message' => 'Report lost RFID gate identification cards immediately to security to deactivate system access.',
        ]);

        Announcement::firstOrCreate([
            'user_id' => 1,
            'title' => 'End of Semester Clean-up',
            'message' => 'Please clear out all personal belongings and locker compartments before checking out for the break.',
        ]);
    }
}
