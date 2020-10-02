@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New booking</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="d-flex">
                            <div class="col-sm-6">
                                <dl>
                                    <dt>Ride</dt>
                                    <dd>
                                        {{ $ride->route->locations->where('id', $startLocationId)->first()->name }}
                                        ->
                                        {{ $ride->route->locations->where('id', $endLocationId)->first()->name }}
                                    </dd>
                                    <dt>Departure date</dt>
                                    <dd>
                                        {{ $travelDate->format('d-M-Y') }},
                                        {{ $ride->departure_time->addMinutes(
                                                    $ride->route->locations
                                                    ->where('id', $startLocationId)
                                                    ->first()
                                                    ->pivot->minutes_from_departure)
                                                    ->format('H:i') }}
                                    </dd>
                                    <dt>Bus</dt>
                                    <dd>{{ $ride->bus->name }}</dd>
                                </dl>
                            </div>

                            <div class="col-sm-6">
                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="seats">Seats</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('seats') is-invalid @enderror"
                                                   name="seats" id="seats" min="1"  value="{{ old('seats', 1) }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $availableSeats }} available</span>
                                            </div>

                                            @error('seats')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                                    <input type="hidden" name="start_location_id" value="{{ $startLocationId }}">
                                    <input type="hidden" name="end_location_id" value="{{ $endLocationId }}">
                                    <input type="hidden" name="travel_date" value="{{ $travelDate }}">

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Make booking</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
