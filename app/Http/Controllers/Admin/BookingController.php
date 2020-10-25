<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingStatus;
use App\Exceptions\NotEnoughSeatsAvailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatchBookingRequest;
use App\Ride;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = Booking::with('ride', 'startLocation', 'endLocation', 'user')
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(Booking $booking)
    {
        $bookingStatuses = BookingStatus::getKeys();
        $bookedSeats = $this->bookingService->getBookedSeatsSum($booking->ride,
            $booking->startLocation->id,
            $booking->endLocation->id,
            $booking->travel_date->toDateString());
        $availableSeats = $booking->ride->bus->seats - $bookedSeats;

        return view('admin.bookings.edit-status', compact('booking', 'bookingStatuses', 'availableSeats'));
    }

    public function update(PatchBookingRequest $request, Booking $booking)
    {
        try {
            $this->bookingService->updateStatus($booking, $request->validated()['status']);
        } catch (NotEnoughSeatsAvailableException $e) {
            $errors['seats'] = $e->getMessage();

            return redirect()->back()
                ->withErrors($errors);
        }

        session()->flash('status', 'The booking status has been successfully updated.');

        return redirect()->route('admin.bookings.index');
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            session()->flash('status', 'The booking has been successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('status', 'An error occurred while deleting the booking.');
        }

        return redirect()->route('admin.bookings.index');
    }
}
