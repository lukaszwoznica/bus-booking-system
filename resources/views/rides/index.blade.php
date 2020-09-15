@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Rides</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Route</th>
                                    <th scope="col">Departure time</th>
                                    <th scope="col">Arrival time</th>
                                    <th scope="col">Ride date</th>
                                    <th scope="col">Full route</th>
                                    <th scope="col">Booked seats</th>
                                    <th scope="col">Book</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rides as $ride)
                                    <tr>
                                        <td>
                                            {{ "{$startLocation->name} -> {$endLocation->name}"}}
                                        </td>
                                        <td>
                                            {{ $ride->departure_time->addMinutes(
                                                    $ride->route->locations
                                                    ->where('id', $startLocation->id)
                                                    ->first()
                                                    ->pivot->minutes_from_departure)
                                                    ->format('H:i') }}
                                        </td>
                                        <td>
                                            {{ $ride->departure_time->addMinutes(
                                                    $ride->route->locations
                                                    ->where('id', $endLocation->id)
                                                    ->first()
                                                    ->pivot->minutes_from_departure)
                                                    ->format('H:i') }}
                                        </td>
                                        <td>
                                            {{ $departureDate }}
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach($ride->route->locations as $location)
                                                    <li>
                                                        {{ $location->name }} -
                                                        {{ $ride->departure_time->addMinutes(
                                                                $location->pivot->minutes_from_departure)
                                                                ->format('H:i')  }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            0/47
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">Book</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
