<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingStatus;
use App\Exceptions\NotEnoughSeatsAvailableException;
use App\Http\Requests\Booking\PostBookingRequest;
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

        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('ride', 'startLocation', 'endLocation')
            ->latest()
            ->paginate(25);

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
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

    public function store(PostBookingRequest $request)
    {
        try {
            $this->bookingService->create($request->validated());
        } catch (NotEnoughSeatsAvailableException $exception) {
            $errors['seats'] = 'You cannot book more seats than are available.';

            return redirect()->back()
                ->withErrors($errors)
                ->withInput($request->input());
        }

        alert()->success('The booking has been made', 'You will receive an email when your booking is confirmed.')
            ->showConfirmButton('Ok', '#2aae61');

        return redirect()->route('bookings.index');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->canBeCancelled()) {
            $this->bookingService->updateStatus($booking, BookingStatus::CANCELLED);
            alert()->success('The booking has been cancelled.')
                ->showConfirmButton('Ok', '#2aae61');
        } else {
            alert()->warning('This booking can not be cancelled.')
                ->showConfirmButton('Ok', '#2aae61');
        }

        return redirect()->route('bookings.show', $booking);
    }
}
