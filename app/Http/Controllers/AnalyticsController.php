<?php

namespace App\Http\Controllers;

use App\Models\PassSlip;
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
        // A. FACILITY STATISTICS
        $totalResidents = Resident::where('accommodation_type', 'Resident')
            ->whereHas('user', fn ($q) => $q->where('status', 'Active'))
            ->count();

        $totalTransients = Resident::where('accommodation_type', 'Transient')
            ->whereHas('user', fn ($q) => $q->where('status', 'Active'))
            ->count();

        $totalRooms = Room::count();

        $totalCapacity = Room::sum('capacity');

        $occupiedSlots = Resident::whereHas('user', function ($query) {
            $query->where('status', 'active');
        })->count();

        $availableSlots = max(0, $totalCapacity - $occupiedSlots);

        $facilityStatistics = [
            'total_residents' => $totalResidents,
            'total_transients' => $totalTransients,
            'total_rooms' => $totalRooms,
            'total_capacity' => $totalCapacity,
            'occupied_slots' => $occupiedSlots,
            'available_slots' => $availableSlots,
        ];

        // B. RESIDENT AND TRANSIENT ANALYTICS
        $residentCheckInTrend = Resident::where('accommodation_type', 'Resident')
            ->selectRaw('
                YEAR(check_in_date) as year,
                MONTH(check_in_date) as month,
                COUNT(*) as count
            ')
            ->whereNotNull('check_in_date')
            ->groupByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->orderByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->get();

        $residentCheckOutTrend = Resident::where('accommodation_type', 'Resident')
            ->selectRaw('
                YEAR(check_out_date) as year,
                MONTH(check_out_date) as month,
                COUNT(*) as count
            ')
            ->whereNotNull('check_out_date')
            ->groupByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->orderByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->get();

        $transientCheckInTrend = Resident::where('accommodation_type', 'Transient')
            ->selectRaw('
                YEAR(check_in_date) as year,
                MONTH(check_in_date) as month,
                COUNT(*) as count
            ')
            ->whereNotNull('check_in_date')
            ->groupByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->orderByRaw('YEAR(check_in_date), MONTH(check_in_date)')
            ->get();

        $transientCheckOutTrend = Resident::where('accommodation_type', 'Transient')
            ->selectRaw('
                YEAR(check_out_date) as year,
                MONTH(check_out_date) as month,
                COUNT(*) as count
            ')
            ->whereNotNull('check_out_date')
            ->groupByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->orderByRaw('YEAR(check_out_date), MONTH(check_out_date)')
            ->get();

        $checkInCheckOut = [
            'residentCheckInTrend' => $residentCheckInTrend,
            'residentCheckOutTrend' => $residentCheckOutTrend,
            'transientCheckInTrend' => $transientCheckInTrend,
            'transientCheckOutTrend' => $transientCheckOutTrend,
        ];

        // C. PASS SLIP STATISTICS
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $passSlipStatistics = [
            'submitted' => PassSlip::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),

            'used' => PassSlip::where('status', 'Used')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),

            'cancelled' => PassSlip::where('status', 'Cancelled')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),

            'no_pass_slip_logs' => ResidentLog::whereNull('pass_slip_id')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
        ];

        $monthlyPassSlipTrend = PassSlip::selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as submitted,
                SUM(status = "Used") as used,
                SUM(status = "Cancelled") as cancelled
            ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        $withoutPassSlipLeaderboard = ResidentLog::with('resident.user')
            ->whereNull('pass_slip_id')->get()->groupBy('resident_id')
            ->map(fn ($logs) => [
                'resident' => $logs->first()->resident,
                'count' => $logs->count(),
            ])->sortByDesc('count')->take(5)->values();

        // D. MOVEMENT & COMPLIANCE ANALYTICS
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

        $monthlyMovement = ResidentLog::selectRaw('
            YEAR(departed_at) as year,
            MONTH(departed_at) as month,
            COUNT(departed_at) as time_outs
        ')
            ->groupByRaw('YEAR(departed_at), MONTH(departed_at)')
            ->orderByRaw('YEAR(departed_at), MONTH(departed_at)')
            ->get();

        $monthlyReturns = ResidentLog::selectRaw('
            YEAR(returned_at) as year,
            MONTH(returned_at) as month,
            COUNT(returned_at) as time_ins
        ')
            ->whereNotNull('returned_at')
            ->groupByRaw('YEAR(returned_at), MONTH(returned_at)')
            ->orderByRaw('YEAR(returned_at), MONTH(returned_at)')
            ->get();

        // Monthly activity
        $movementStatistics = [
            'daily_out' => ResidentLog::whereDate('departed_at', today())->count(),
            'daily_in' => ResidentLog::whereDate('returned_at', today())->count(),
            'weekly_out' => ResidentLog::whereBetween(
                'departed_at',
                [now()->startOfWeek(), now()->endOfWeek()]
            )->count(),

            'weekly_in' => ResidentLog::whereBetween(
                'returned_at',
                [now()->startOfWeek(), now()->endOfWeek()]
            )->count(),

            'monthly_out' => ResidentLog::whereMonth(
                'departed_at',
                now()->month
            )->whereYear(
                'departed_at',
                now()->year
            )->count(),

            'monthly_in' => ResidentLog::whereMonth(
                'returned_at',
                now()->month
            )->whereYear(
                'returned_at',
                now()->year
            )->count(),

            'without_pass_slip' => ResidentLog::whereNull('pass_slip_id')->count(),
        ];
        $totalLateReturns = ResidentLog::whereNotNull('pass_slip_id')
            ->whereNotNull('returned_at')
            ->get()
            ->filter(function ($log) {
                if (! $log->passSlip) {
                    return false;
                }

                $expectedReturn = Carbon::parse(
                    $log->passSlip->requested_date_in.' '.$log->passSlip->requested_time_in
                );

                return $log->returned_at->gt($expectedReturn);
            })
            ->count();
        $withoutSlipLeaderboard = ResidentLog::with('resident.user')
            ->whereNull('pass_slip_id')
            ->get()
            ->groupBy('resident_id')
            ->map(fn ($logs) => [
                'resident' => $logs->first()->resident,
                'count' => $logs->count(),
            ])
            ->sortByDesc('count')
            ->take(5);

        $lateReturnLeaderboard = ResidentLog::with([
            'resident.user',
            'passSlip',
        ])
            ->whereNotNull('returned_at')
            ->get()
            ->filter(function ($log) {

                if (! $log->passSlip) {
                    return false;
                }

                $expected = Carbon::parse(
                    $log->passSlip->requested_date_in.' '.$log->passSlip->requested_time_in
                );

                return $log->returned_at->gt($expected);
            })->groupBy('resident_id')->map(fn ($logs) => [
                'resident' => $logs->first()->resident,
                'count' => $logs->count(),
            ])->sortByDesc('count')->take(5)->values();

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

        $demographicsTrend = [
            'gender' => $gender,
            'accommodation_type' => $accommodation_type,
            'resident_type' => $resident_type,
        ];

        return view('analytics', compact(
            'facilityStatistics',
            'checkInCheckOut',
            'passSlipStatistics',
            'monthlyPassSlipTrend',
            'withoutPassSlipLeaderboard',
            'dailyAttendance',
            'weeklyActivity',
            'monthlyMovement',
            'monthlyReturns',
            'movementStatistics',
            'totalLateReturns',
            'withoutSlipLeaderboard',
            'lateReturnLeaderboard',
            'demographicsTrend',
        ));
    }
}
