<?php

namespace App\Http\Controllers;

use App\Exceptions\NotEnoughSeatsAvailableException;
use App\Http\Requests\StoreBookingRequest;
use App\Location;
use App\Ride;
use App\Services\BookingService;
use App\Services\RideService;
use Carbon\Carbon;

class BookingController extends Controller
{
    private RideService $ridesService;
    private BookingService $bookingService;

    public function __construct(RideService $rideService, BookingService $bookingService)
    {
        $this->ridesService = $rideService;
        $this->bookingService = $bookingService;

        $this->middleware('auth');
    }

    public function create(Ride $ride, Location $startLocation, Location $endLocation, string $date)
    {
        $validRide = $this->ridesService
            ->getRidesByLocations($startLocation, $endLocation, $date, [$ride->route->id])
            ->find($ride);

        if ($validRide) {
            $availableSeats = $validRide->bus->seats - $validRide->booked_seats;

            return view('bookings.create', [
                'ride' => $validRide,
                'startLocationId' => $startLocation->id,
                'endLocationId' => $endLocation->id,
                'travelDate' => Carbon::parse($date),
                'availableSeats' => $availableSeats
            ]);
        }

        return redirect()->route('home');
    }

    public function store(StoreBookingRequest $request)
    {
        try {
            $this->bookingService->create($request->validated());
        } catch (NotEnoughSeatsAvailableException $exception) {
            $errors['seats'] = 'You cannot book more seats than are available.';

            return redirect()->back()
                ->withErrors($errors)
                ->withInput($request->input());
        }

        session()->flash('status', 'The booking has been successfully created.');

        return redirect()->route('home');
    }
}
