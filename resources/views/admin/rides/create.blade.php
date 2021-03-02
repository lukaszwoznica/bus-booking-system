@extends('adminlte::page')

@section('title', 'Add ride')

@section('content_header')
    <h1>Rides</h1>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.rides.store') }}" method="POST">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-outline card-primary elevation-2">
                        <div class="card-header">
                            <h4>Create new ride</h4>
                        </div>

                        <form action="{{ route('admin.rides.store') }}" method="POST">
                            <div class="card-body">
                                @csrf

                                <div class="form-group">
                                    <label for="route">Route</label>
                                    <select name="route_id" id="route" required
                                            class="custom-select @error('route_id') is-invalid @enderror">
                                        <option value="" hidden>Choose route</option>
                                        @foreach($routes as $route)
                                            <option
                                                value="{{ $route->id }}" {{ old('route_id') == $route->id ? "selected" : ""}}>
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
                                            <option
                                                value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? "selected" : ""}}>
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
                                    <input type="time" class="form-control @error('bus_id') is-invalid @enderror"
                                           required name="departure_time" id="departure-time"
                                           value="{{ old('departure_time') }}">

                                    @error('departure_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group text-center mt-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" name="ride_type"
                                               id="ride-type-single"
                                               value="single" {{ ! old('ride_type') || old('ride_type') == 'single' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="ride-type-single">
                                            Single ride
                                        </label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" name="ride_type"
                                               id="ride-type-cyclic"
                                               value="cyclic" {{ old('ride_type') == 'cyclic' ? "checked" : "" }}>
                                        <label class="custom-control-label" for="ride-type-cyclic">
                                            Cyclic ride
                                        </label>
                                    </div>

                                    @error('ride_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div id="singleRideInputsWrapper"
                                     style="display: {{ ! old('ride_type') || old('ride_type') == 'single' ? "block" : "none" }}">
                                    <div class="form-group">
                                        <label for="ride-date">Ride date</label>
                                        <input type="date" name="ride_date" id="ride-date" required
                                               class="form-control @error('ride_date') is-invalid @enderror datepicker"
                                               value="{{ old('ride_date') }}"
                                            {{ old('ride_type') == 'cyclic' ? "disabled" : "" }}>

                                        @error('ride_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="cyclicRideInputsWrapper"
                                     style="display: {{ old('ride_type') == 'cyclic' ? "block" : "none" }}">
                                    <div class="form-group">
                                        @foreach($days as $day)
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input day-checkbox" type="checkbox"
                                                       name="days[{{ $day }}]" value="1" id="{{ $day }}"
                                                    {{ ! old('ride_type') || old('ride_type') == 'single' ? "disabled" : "" }}
                                                    {{ isset(old('days')[$day]) ? "checked" : "" }}>

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
                                        <input type="date" name="start_date" id="start-date" required
                                               class="form-control @error('start_date') is-invalid @enderror datepicker"
                                               value="{{ old('start_date') }}"
                                            {{ ! old('ride_type') || old('ride_type') == 'single' ? "disabled" : "" }}>

                                        @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="end-date">End date</label>
                                        <input type="date" name="end_date" id="end-date" value="{{ old('end_date') }}"
                                               class="form-control @error('end_date') is-invalid @enderror datepicker"
                                            {{ ! old('ride_type') || old('ride_type') == 'single' ? "disabled" : "" }}>
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

                            <div class="card-footer row justify-content-center">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('adminlte_js')
    <script>
        window.addEventListener('load', function () {
            flatpickr('.datepicker', {
                allowInput: true,
                minDate: 'today',
                position: 'auto left',
                locale: {
                    firstDayOfWeek: 1
                },
            });

            flatpickr('#departure-time', {
                allowInput: true,
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i",
                position: 'auto left',
            })
        })
    </script>
@endpush
