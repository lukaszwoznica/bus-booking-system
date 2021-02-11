@extends('adminlte::page')

@section('title', 'Edit booking status')

@section('content_header')
    <h1>Edit booking status</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4 order-last order-md-first">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Update booking status</h4>
                    </div>
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                @foreach($bookingStatuses as $status)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="{{ strtolower($status) . 'Status' }}"
                                               name="status"
                                               value="{{ strtolower($status) }}" class="custom-control-input"
                                            {{ $booking->status == strtolower($status) ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="{{ strtolower($status) . 'Status' }}">
                                            {{ ucfirst(strtolower($status)) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer row justify-content-center">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6 col-lg-5">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Booking details</h4>
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>User</dt>
                            <dd>{{ $booking->user->getFullName() }}</dd>
                            <dt>Ride</dt>
                            <dd>{{ "{$booking->ride->id}. {$booking->ride->route->name}" }}</dd>
                            <dt>Booked route</dt>
                            <dd>{{ "{$booking->startLocation->name} -> {$booking->endLocation->name}"  }}</dd>
                            <dt>Date</dt>
                            <dd>{{ $booking->travel_date->format('d.m.Y') }}</dd>
                            <dt>Seats</dt>
                            <dd>{{ $booking->seats }}</dd>
                            <dt>Available seats</dt>
                            <dd>{{ $availableSeats }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
