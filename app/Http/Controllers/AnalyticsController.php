<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\ResidentLog;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        // Demographics trend
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

        $totalResidents = User::where('status', 'active')
            ->whereIn('user_type', ['resident'])
            ->count();

        $demographicsTrend = [
            'gender' => $gender,
            'accommodation_type' => $accommodation_type,
            'resident_type' => $resident_type,
            'total_residents' => $totalResidents,
        ];

        // Facility overview
        $totalRooms = Room::count();
        $totalCapacity = Room::sum('capacity');

        $occupiedSlots = Resident::whereHas('user', function ($query) {
            $query->where('status', 'active');
        })->count();

        $availableSlots = max(0, $totalCapacity - $occupiedSlots);

        $residentsAssigned = Resident::whereNotNull('room_id')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })->count();

        $occupancyRate = $totalCapacity > 0
            ? round(($occupiedSlots / $totalCapacity) * 100)
            : 0;

        $occupancyTrend = [
            'total_rooms' => $totalRooms,
            'total_capacity' => $totalCapacity,
            'occupied_slots' => $occupiedSlots,
            'available_slots' => $availableSlots,
            'residents_assigned' => $residentsAssigned,
            'occupancy_rate' => $occupancyRate,
        ];

        // Daily attendance
        $today = Carbon::today();

        $dailyTimeOut = ResidentLog::whereDate('departed_at', $today)->count();
        $dailyTimeIn = ResidentLog::whereDate('returned_at', $today)->count();

        $dailyAttendance = [
            'time_out' => $dailyTimeOut,
            'time_in' => $dailyTimeIn,
        ];

        // Weekly attendance activity
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyLogs = ResidentLog::where(function ($query) use ($startOfWeek, $endOfWeek) {
            $query->whereBetween('departed_at', [$startOfWeek, $endOfWeek])
                ->orWhereBetween('returned_at', [$startOfWeek, $endOfWeek]);
        })->get();

        $weeklyActivity = collect(range(0, 6))->map(function ($day) use ($weeklyLogs, $startOfWeek) {
            $date = $startOfWeek->copy()->addDays($day);

            return [
                'day' => $date->format('D'),

                'time_out' => $weeklyLogs->filter(function ($log) use ($date) {
                    return Carbon::parse($log->departed_at)->isSameDay($date);
                })->count(),

                'time_in' => $weeklyLogs->filter(function ($log) use ($date) {
                    return Carbon::parse($log->returned_at)->isSameDay($date);
                })->count(),
            ];
        });

        // Monthly check-in trend
        $checkInTrend = Resident::selectRaw('
            YEAR(check_in_date) as year,
            MONTH(check_in_date) as month,
            COUNT(*) as count
        ')
            ->whereNotNull('check_in_date')
            ->groupByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->orderByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->get();

        // Monthly check-out trend
        $checkOutTrend = Resident::selectRaw('
            YEAR(check_out_date) as year,
            MONTH(check_out_date) as month,
            COUNT(*) as count
        ')
            ->whereNotNull('check_out_date')
            ->groupByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->orderByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->get();

        return view('analytics', compact(
            'demographicsTrend',
            'occupancyTrend',
            'dailyAttendance',
            'weeklyActivity',
            'checkInTrend',
            'checkOutTrend'
        ));
    }
}

// namespace App\Http\Controllers;

// use App\Models\Resident;
// use App\Models\Room;
// use App\Models\User;
// use App\Models\ResidentLog;
// use Illuminate\View\View;
// use Carbon\Carbon;

// class AnalyticsController extends Controller
// {
//     public function index(): View
//     {
//         // demographics trend
//         $gender = User::where('status', 'active')
//             ->whereIn('user_type', ['resident'])
//             ->selectRaw('gender, COUNT(*) as count')
//             ->groupBy('gender')
//             ->get();

//         $accommodation_type = Resident::join('users', 'users.id', '=', 'residents.user_id')
//             ->where('users.status', 'active')
//             ->selectRaw('accommodation_type, COUNT(*) as count')
//             ->groupBy('accommodation_type')
//             ->get();

//         $resident_type = Resident::join('users', 'users.id', '=', 'residents.user_id')
//             ->where('users.status', 'active')
//             ->selectRaw('resident_type, COUNT(*) as count')
//             ->groupBy('resident_type')
//             ->get();

//         $totalResidents = User::where('status', 'active')->whereIn('user_type', ['resident'])->count();
//         $demographicsTrend = [
//             'gender' => $gender,
//             'accommodation_type' => $accommodation_type,
//             'resident_type' => $resident_type,
//             'total_residents' => $totalResidents,
//         ];

//         // facility overview
//         $totalRooms = Room::count();
//         $totalCapacity = Room::sum('capacity');
//         $occupiedSlots = Resident::whereHas('user', function ($query) {
//             $query->where('status', 'active');
//         })->count();
//         $availableSlots = max(0, $totalCapacity - $occupiedSlots);
//         // residents assigned
//         $residentsAssigned = Resident::whereNotNull('room_id')
//             ->whereHas('user', function ($query) {
//                 $query->where('status', 'active');
//             })->count();
//         $occupancyTrend = [
//             'total_rooms' => $totalRooms,
//             'total_capacity' => $totalCapacity,
//             'occupied_slots' => $occupiedSlots,
//             'available_slots' => $availableSlots,
//         ];

//         // logs trend
//         $today = Carbon::today();
//         $dailyTimeOut = ResidentLog::whereDate('departed_at', $today)->count();
//         $dailyTimeIn = ResidentLog::whereDate('returned_at', $today)->count();
//         $dailyAttendance = [
//             'time_out' => $dailyTimeOut,
//             'time_in' => $dailyTimeIn,
//             ];

//         // check-in trend
//         $checkInTrend = Resident::selectRaw('
//             YEAR(check_in_date) as year,
//             MONTH(check_in_date) as month,
//             COUNT(*) as count')
//             ->whereNotNull('check_in_date')
//             ->groupByRaw('YEAR(check_in_date), MONTH(check_in_date)')
//             ->orderByRaw('YEAR(check_in_date), MONTH(check_in_date)')
//             ->get();
//         $checkOutTrend = Resident::selectRaw('
//             YEAR(check_out_date) as year,
//             MONTH(check_out_date) as month,
//             COUNT(*) as count')
//             ->whereNotNull('check_out_date')
//             ->groupByRaw('YEAR(check_out_date), MONTH(check_out_date)')
//             ->orderByRaw('YEAR(check_out_date), MONTH(check_out_date)')
//             ->get();

//         return view('analytics', compact('demographicsTrend', 'checkInTrend', 'occupancyTrend', 'dailyAttendance', 'checkOutTrend'));
//     }
