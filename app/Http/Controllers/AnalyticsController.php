<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Room;
use App\Models\User;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        // demographics trend
        $gender = User::where('status', 'active')
            ->whereIn('user_type', ['resident'])
            ->selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        $accommodation_type = Resident::join('users', 'users.id', '=', 'residents.user_id')
            ->where('users.status', 'active')
            ->selectRaw('accommodation_type, COUNT(*) as count')
            ->groupBy('accommodation_type')
            ->get();

        $resident_type = Resident::join('users', 'users.id', '=', 'residents.user_id')
            ->where('users.status', 'active')
            ->selectRaw('resident_type, COUNT(*) as count')
            ->groupBy('resident_type')
            ->get();

        $totalResidents = User::where('status', 'active')->whereIn('user_type', ['resident'])->count();
        $demographicsTrend = [
            'gender' => $gender,
            'accommodation_type' => $accommodation_type,
            'resident_type' => $resident_type,
            'total_residents' => $totalResidents,
        ];
        // check-in trend
        $checkInTrend = Resident::selectRaw('
            YEAR(check_in_date) as year,
            MONTH(check_in_date) as month,
            COUNT(*) as count')
            ->whereNotNull('check_in_date')
            ->groupByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->orderByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->get();

        // occupancy trend
        // total
        $totalRooms = Room::count();
        $totalCapacity = Room::sum('capacity');
        $totalOccupants = Resident::whereHas('user', function ($query) {
            $query->where('status', 'active');
        })->count();

        // residents assigned
        $residentsAssigned = Resident::whereNotNull('room_id')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })->count();

        // occupied slots
        $availableSlots = $totalCapacity - $residentsAssigned;
        $occupancyTrend = [
            'total_rooms' => $totalRooms,
            'total_capacity' => $totalCapacity,
            'occupied_slots' => $residentsAssigned,
            'available_slots' => $availableSlots,
        ];

        return view('analytics', compact('demographicsTrend', 'checkInTrend', 'occupancyTrend'));
    }
}
