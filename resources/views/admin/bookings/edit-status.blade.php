@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update booking status</div>

                    <div class="card-body">
                        @error('seats')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-flex">
                            <div class="col-6">
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

                            <div class="col-6">
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
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

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
