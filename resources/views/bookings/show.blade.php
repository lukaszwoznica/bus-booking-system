@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-9 col-lg-8 col-xl-6">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <h4 class="m-0">
                            Booking details
                        </h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <dl class="row">
                            <dt class="col-sm-4">Ride</dt>
                            <dd class="col-sm-8">
                                {{ $booking->startLocation->name }}
                                <i class="fas fa-arrow-right mx-2"></i>
                                {{ $booking->endLocation->name }}
                            </dd>
                            <dt class="col-sm-4">Departure</dt>
                            <dd class="col-sm-8">
                                {{ $booking->travel_date
                                    ->setTimeFromTimeString($booking->ride->getArrivalTimeToLocation($booking->startLocation->id))
                                    ->format('d M Y, H:i')
                                }}
                            </dd>
                            <dt class="col-sm-4">Arrival</dt>
                            <dd class="col-sm-8">
                                {{ $booking->travel_date
                                    ->setTimeFromTimeString($booking->ride->getArrivalTimeToLocation($booking->startLocation->id))
                                    ->addMinutes($booking->endLocation->getMinutesFromDepartureInRoute($booking->ride->route->id))
                                    ->format('d M Y, H:i')
                                }}
                            </dd>
                            <dt class="col-sm-4">Seats</dt>
                            <dd class="col-sm-8">{{ $booking->seats }}</dd>
                            <dt class="col-sm-4">Made at</dt>
                            <dd class="col-sm-8">{{ $booking->created_at->format('d M Y, H:i:s') }}</dd>
                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">{{ ucfirst($booking->status) }}</dd>
                            <dt class="col-sm-4">Last status update</dt>
                            <dd class="col-sm-8">{{$booking->updated_at->format('d M Y, H:i:s') }}</dd>
                        </dl>
                    </div>

                    <div class="card-footer text-center">
                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm btn-danger"
                                {{ !$booking->canBeCancelled() ? 'disabled' : ''}}>
                                Cancel Booking
                            </button>
                            <p class="mb-0">
                                <small>You can cancel your booking up to two hours before departure.</small>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
