@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit ride</div>

                    <div class="card-body">
                        <form action="{{ route('admin.rides.update', $ride) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="route">Route</label>
                                <select name="route_id" id="route" required
                                        class="custom-select @error('route_id') is-invalid @enderror">
                                    <option value="" hidden>Choose route</option>
                                    @foreach($routes as $route)
                                        <option
                                            value="{{ $route->id }}" {{ old('route_id', $ride->route->id) == $route->id ? "selected" : ""}}>
                                            {{ $route->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('route_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bus">Bus</label>
                                <select name="bus_id" id="bus" required
                                        class="custom-select @error('bus_id') is-invalid @enderror">
                                    <option value="" hidden>Choose bus</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}" {{ old('bus_id', $ride->bus->id) == $bus->id ? "selected" : ""}}>
                                            {{ $bus->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('bus_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="departure-time">Departure time</label>
                                <input type="time" class="form-control @error('bus_id') is-invalid @enderror" required
                                       name="departure_time" id="departure-time"
                                       value="{{ old('departure_time', $ride->departure_time->format('H:i')) }}">

                                @error('departure_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ride_type" id="ride-type-single"
                                           value="single" {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                                || old('ride_type') == 'single' ? "checked" : "" }}>
                                    <label class="form-check-label" for="ride-type-single">
                                        Single ride
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ride_type" id="ride-type-cyclic"
                                           value="cyclic" {{ ($ride->isCyclic() && ! old('ride_type'))
                                                                || old('ride_type') == 'cyclic' ? "checked" : "" }}>
                                    <label class="form-check-label" for="ride-type-cyclic">
                                        Cyclic ride
                                    </label>
                                </div>

                                @error('ride_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ride-date">Ride date</label>
                                        <input type="date" class="form-control @error('ride_date') is-invalid @enderror"
                                               name="ride_date" id="ride-date" required
                                               value="{{ old('ride_date', $ride->ride_date ? $ride->ride_date->format('Y-m-d') : '') }}"
                                                {{ ($ride->isCyclic() && ! old('ride_type'))
                                                    || old('ride_type') == 'cyclic' ? "disabled" : "" }}>

                                        @error('ride_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @foreach($days as $day)
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input day-checkbox" type="checkbox"
                                                       name="days[{{ $day }}]" value="1" id="{{ $day }}"
                                                        {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                            || old('ride_type') == 'single' ? "disabled" : "" }}
                                                        {{  ($ride->schedule && $ride->schedule->$day && ! old('ride_type'))
                                                            || isset(old('days')[$day]) ? "checked" : "" }}>

                                                <label class="custom-control-label" for="{{ $day }}">
                                                    {{ ucfirst($day) }}
                                                </label>
                                            </div>
                                        @endforeach

                                        @error('days')
                                            <span class="invalid-feedback" style="display: block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="start-date">Start date</label>
                                        <input type="date"
                                               class="form-control @error('start_date') is-invalid @enderror"
                                               name="start_date" id="start-date" required
                                               value="{{ old('start_date',
                                                        isset($ride->schedule->start_date) ? $ride->schedule->start_date->format('Y-m-d') : '') }}"
                                                {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                    || old('ride_type') == 'single' ? "disabled" : "" }}>

                                        @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="end-date">End date</label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                               name="end_date" id="end-date"
                                               value="{{ old('end_date', isset($ride->schedule->end_date) ? $ride->schedule->end_date->format('Y-m-d') : '') }}"
                                                {{ (! $ride->isCyclic() && ! old('ride_type'))
                                                    || old('ride_type') == 'single' ? "disabled" : "" }}>
                                        <small class="form-text text-muted">
                                            Leave blank to make the ride cycle endless
                                        </small>

                                        @error('end_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
