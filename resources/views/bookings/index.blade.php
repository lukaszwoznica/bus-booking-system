@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Bookings list</div>

                    <div class="card-body">
                        @include('flash::message')

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Route</th>
                                <th scope="col">Travel date</th>
                                <th scope="col">Departure time</th>
                                <th scope="col">Seats</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        {{ "{$booking->startLocation->name} -> {$booking->endLocation->name}" }}
                                    </td>
                                    <td>{{ $booking->travel_date->format('d.m.Y') }}</td>
                                    <td>
                                        {{ $booking->ride->departure_time->addMinutes(
                                                $booking->ride->route->locations
                                                ->where('id', $booking->startLocation->id)
                                                ->first()
                                                ->pivot->minutes_from_departure)
                                                ->format('H:i') }}
                                    </td>
                                    <td>{{ $booking->seats }}</td>
                                    <td>{{ ucwords($booking->status) }}</td>
                                    <td>
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-danger"
                                                {{ !$booking->canBeCancelled() ? 'disabled' : ''}}>
                                                Cancel booking
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <div>
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
