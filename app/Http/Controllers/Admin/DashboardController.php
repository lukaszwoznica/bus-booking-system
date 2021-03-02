<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Ride;
use App\Route;
use App\Services\BookingService;
use App\User;

class DashboardController extends Controller
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $newBookings = Booking::new()->count();
        $activeRides = Ride::active()->count();
        $totalRoutes = Route::all()->count();
        $registeredUsers = User::all()->count();

        $bookingsByMonthData = $this->getBookingsByMonthChartData();
        $ridesByRouteData = $this->getRoutesWithMostRidesChartData();

        return view('admin.dashboard', compact('bookingsByMonthData', 'ridesByRouteData',
            'newBookings', 'activeRides', 'totalRoutes', 'registeredUsers'));
    }

    private function getBookingsByMonthChartData(): array
    {
        $bookingsCountData = $this->bookingService->lastMonthsCount(6);
        $thisMonth = end($bookingsCountData);
        $lastMonth = prev($bookingsCountData);
        $labels = $data = [];

        foreach ($bookingsCountData as $month => $count) {
            $labels[] = $month;
            $data[] = $count;
        }

        $chartData['labels'] = $labels;
        $chartData['datasets'] = [[
            'label' => 'Bookings',
            'backgroundColor' => 'rgba(102, 16, 242, 0.5)',
            'hoverBackgroundColor' => 'rgba(102, 16, 242, 0.7)',
            'borderWidth' => 1,
            'borderColor' => 'rgba(102, 16, 242, 0.8)',
            'hoverBorderColor' => 'rgba(102, 16, 242, 1)',
            'data' => $data
        ]];
        $chartData['stats'] = [
            'percentageChange' => round(($thisMonth - $lastMonth) / $lastMonth * 100, 1),
            'avg' => round(collect($bookingsCountData)->avg(), 1),
            'total' => collect($bookingsCountData)->sum()
        ];

        return $chartData;
    }

    private function getRoutesWithMostRidesChartData(): array
    {
        $routes = Route::withCount(['rides' => fn($query) => $query->active()])
            ->having('rides_count', '>', 0)
            ->orderByDesc('rides_count')
            ->limit(10)
            ->get();

        $labels = $data = [];

        $routes->each(function ($route) use (&$labels, &$data) {
            $labels[] = $route->id . '. ' . $route->name;
            $data[] = $route->rides_count;
        });

        $chartData['labels'] = $labels;
        $chartData['datasets'] = [[
            'data' => $data,
            'backgroundColor' => [
                'rgba(103, 183, 220, 0.9)',
                'rgba(103, 148, 220, 0.9)',
                'rgba(103, 113, 220, 0.9)',
                'rgba(128, 103, 220, 0.9)',
                'rgba(163, 103, 220, 0.9)',
                'rgba(199, 103, 220, 0.9)',
                'rgba(220, 103, 206, 0.9)',
                'rgba(220, 103, 171, 0.9)',
                'rgba(220, 103, 136, 0.9)',
                'rgba(220, 103, 112, 0.9)',
            ]
        ]];

        return $chartData;
    }
}
