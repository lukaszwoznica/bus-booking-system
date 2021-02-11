<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingStatus;
use App\Exceptions\NotEnoughSeatsAvailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Booking\PatchBookingRequest;
use App\Services\BookingService;

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
        $bookedSeats = $this->bookingService->getBookedSeatsSum(
            $booking->ride,
            $booking->startLocation->id,
            $booking->endLocation->id,
            $booking->travel_date->toDateString()
        );
        $availableSeats = $booking->ride->bus->seats - $bookedSeats;

        return view('admin.bookings.edit-status', compact('booking', 'bookingStatuses', 'availableSeats'));
    }

    public function update(PatchBookingRequest $request, Booking $booking)
    {
        try {
            $this->bookingService->updateStatus($booking, $request->validated()['status']);
        } catch (NotEnoughSeatsAvailableException $e) {
            return redirect()->back()->withToastError($e->getMessage());
        }

        return redirect()->route('admin.bookings.index')
            ->withToastSuccess('The booking status has been successfully updated!');
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')
                ->withToastError('An error occurred while deleting the booking.');
        }

        return redirect()->route('admin.bookings.index')
            ->withToastSuccess('The booking has been successfully deleted!');
    }
}
