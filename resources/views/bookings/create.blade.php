@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <h4 class="m-0">
                            New booking
                        </h4>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <dl>
                                    <dt>Ride</dt>
                                    <dd>
                                        {{ $ride->route->locations->where('id', $startLocationId)->first()->name }}
                                        <i class="fas fa-arrow-right mx-1"></i>
                                        {{ $ride->route->locations->where('id', $endLocationId)->first()->name }}
                                    </dd>
                                    <dt>Departure</dt>
                                    <dd>
                                        {{ $travelDate->format('d M Y') }},
                                        {{ $ride->getArrivalTimeToLocation($startLocationId) }}
                                    </dd>
                                    <dt>Bus</dt>
                                    <dd>{{ $ride->bus->name }}</dd>
                                </dl>
                            </div>

                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group ">
                                        <label for="seats">Seats</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control input-dark @error('seats') is-invalid @enderror"
                                                   name="seats" id="seats" min="1" value="{{ old('seats', 1) }}"
                                                   required>
                                            <div class="input-group-append">
                                                <span class="input-group-text border-0 bg-dark-lightest text-white">
                                                    {{ $availableSeats }} available
                                                </span>
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

                                    <div class="form-group d-flex justify-content-center mt-4">
                                        <div class="col-8">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                Make Booking
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
