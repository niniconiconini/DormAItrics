<!-- ?php

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
            'title' => 'Absolutely Magnificent Rooms!',
            'review_rating' => 5,
            'message' => 'The Dormitory is clean and well maintained.',
        ]);

        // New Seeds
        Review::firstOrCreate([
            'resident_id' => 2,
        ], [
            'title' => 'Great Study Environment',
            'review_rating' => 4,
            'message' => 'Very peaceful place to focus on academic requirements and projects.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 3,
        ], [
            'title' => 'Comfortable and Cozy',
            'review_rating' => 5,
            'message' => 'Facilities are updated, and the air conditioning works perfectly.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 4,
        ], [
            'title' => 'Accessible Location',
            'review_rating' => 4,
            'message' => 'Very near the campus and local coffee shops. Highly convenient!',
        ]);

        Review::firstOrCreate([
            'resident_id' => 5,
        ], [
            'title' => 'Friendly Management',
            'review_rating' => 5,
            'message' => 'The staff and dorm managers are super accommodating and helpful.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 6,
        ], [
            'title' => 'Decent Short Stay',
            'review_rating' => 3,
            'message' => 'Good for transients, though internet speed could be improved slightly.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 7,
        ], [
            'title' => 'Safe and Secure',
            'review_rating' => 5,
            'message' => 'I feel very secure with the strict gate protocols and security measures.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 8,
        ], [
            'title' => 'Value for Money',
            'review_rating' => 4,
            'message' => 'Clean rooms and great amenities for an affordable price point.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 9,
        ], [
            'title' => 'Wonderful Community',
            'review_rating' => 5,
            'message' => 'Made great friends here. The lounge areas are fantastic.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 10,
        ], [
            'title' => 'Quick Transient Stay',
            'review_rating' => 4,
            'message' => 'Check-in was seamless and the room was ready upon arrival.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 11,
        ], [
            'title' => 'Spotless Cleanliness',
            'review_rating' => 5,
            'message' => 'The housekeeping team does a wonderful job maintaining the common areas.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 12,
        ], [
            'title' => 'Peaceful Nights',
            'review_rating' => 4,
            'message' => 'Quiet hours are strictly followed, allowing for a good night sleep.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 13,
        ], [
            'title' => 'Superb Facilities',
            'review_rating' => 5,
            'message' => 'Everything from the study desks to the bathrooms are top-notch.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 14,
        ], [
            'title' => 'Convenient Booking',
            'review_rating' => 4,
            'message' => 'The digital pass slips and systems make everything so hassle-free.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 15,
        ], [
            'title' => 'Exceeded Expectations',
            'review_rating' => 5,
            'message' => 'Better than expected! Will definitely recommend to other students.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 16,
        ], [
            'title' => 'Good Transient Experience',
            'review_rating' => 4,
            'message' => 'Clean temporary accommodation close to everything we needed.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 17,
        ], [
            'title' => 'Reliable Utilities',
            'review_rating' => 5,
            'message' => 'No issues with water supply or electricity throughout the semester.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 18,
        ], [
            'title' => 'Pleasant Atmosphere',
            'review_rating' => 4,
            'message' => 'Lighting in the hallways and rooms creates a very welcoming vibe.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 19,
        ], [
            'title' => 'Awesome Stay!',
            'review_rating' => 5,
            'message' => 'No complaints at all. Truly feels like a second home.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 20,
        ], [
            'title' => 'Well Maintained',
            'review_rating' => 4,
            'message' => 'Repairs and maintenance requests are addressed quickly by management.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 21,
        ], [
            'title' => 'Perfect for Students',
            'review_rating' => 5,
            'message' => 'Proximity to university buildings saves so much travel time.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 22,
        ], [
            'title' => 'Comfortable Bedding',
            'review_rating' => 4,
            'message' => 'Sleep quality has been great since moving into this room.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 23,
        ], [
            'title' => 'Smooth Operations',
            'review_rating' => 5,
            'message' => 'The face recognition gate scanning makes entry fast and secure.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 24,
        ], [
            'title' => 'Helpful Staff',
            'review_rating' => 4,
            'message' => 'Front desk is always ready to assist with package deliveries and inquiries.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 25,
        ], [
            'title' => 'Highly Recommended',
            'review_rating' => 5,
            'message' => 'Best student dormitory around the Taft area by far.',
        ]);

        Review::firstOrCreate([
            'resident_id' => 26,
        ], [
            'title' => 'Cozy Transient Room',
            'review_rating' => 4,
            'message' => 'Had a wonderful and restful stay during my brief visit.',
        ]);
    }
} -->
