@extends('layouts.app')

@section('inactive-account-alert')
    @include('partials.inactive-account-alert')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <div class="col-sm-7">
                            <h4 class="m-0">
                                Rides form {{ $startLocation->name }} to {{ $endLocation->name }}
                            </h4>
                        </div>
                        <div class="col-sm-5 d-flex align-items-center justify-content-end">
                            <a class="{{ $departureDate->isToday() ? 'disabled' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['date' => $departureDate->subDay()->toDateString()]) }}">
                                <i class="fas fa-chevron-circle-left"></i>
                            </a>
                            <h5 class="my-0 mx-2">
                                {{ $departureDate->addDay()->format('d M Y') }}
                            </h5>
                            <a href="{{ request()->fullUrlWithQuery(['date' => $departureDate->addDay()->toDateString()]) }}">
                                <i class="fas fa-chevron-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($rides->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table text-white">
                                    <thead>
                                    <tr>
                                        <th scope="col">Ride</th>
                                        <th scope="col">Departure time</th>
                                        <th scope="col">Arrival time</th>
                                        <th scope="col">Booked seats</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($rides as $ride)
                                        <tr>
                                            <td>
                                                {{ $startLocation->name }}
                                                <i class="fas fa-arrow-right mx-2"></i>
                                                {{ $endLocation->name }}
                                            </td>
                                            <td>
                                                {{ $ride->getArrivalTimeToLocation($startLocation->id) }}
                                            </td>
                                            <td>
                                                {{ $ride->getArrivalTimeToLocation($endLocation->id) }}
                                            </td>
                                            <td>
                                                @php
                                                    $perc = $ride->bus->seats == 0 ? 100 : $ride->booked_seats * 100 / $ride->bus->seats;
                                                @endphp
                                                <div class="progress">
                                                    <div
                                                        class="progress-bar {{ $perc == 100 ? 'bg-danger' : ($perc >= 85  ? 'bg-warning' : '') }}"
                                                        role="progressbar" style="width: {{ $perc }}%">
                                                    </div>
                                                </div>
                                                {{ $ride->bus->seats - $ride->booked_seats }} seats available
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('bookings.create', [
                                                        $ride->id,
                                                        $startLocation->id,
                                                        $endLocation->id,
                                                        request()->get('date')])
                                                }}">
                                                    Book This Ride
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="collapse-row">
                                            <td colspan="5" class="text-center">
                                            <span data-toggle="tooltip" data-placement="top" title="Full route">
                                                <button class="btn btn-link btn-block btn-collapse"
                                                        data-toggle="collapse"
                                                        data-target="#collapseRoute{{ $loop->iteration }}">
                                                    <i class="fas fa-lg fa-chevron-down rotate"></i>
                                                </button>
                                            </span>
                                                <div id="collapseRoute{{ $loop->iteration }}" class="collapse">
                                                    <ul class="timeline">
                                                        @foreach($ride->route->locations as $location)
                                                            <li class="d-flex align-items-center
                                                            {{ $location->pivot->order >= $startLocation->getOrderInRoute($ride->route->id)
                                                                && $location->pivot->order <= $endLocation->getOrderInRoute($ride->route->id)
                                                                ? 'active' : '' }}">
                                                            <span class="badge badge-secondary mr-2">
                                                                {{ $ride->getArrivalTimeToLocation($location->id) }}
                                                            </span>
                                                                <span>{{ $location->name }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="far fa-6x fa-frown mt-4 mb-3"></i>
                                <h4>Unfortunately, no rides were found. </h4>
                                <p>Please search for another date or try again later.</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', function () {
            $(".btn-collapse").click(function () {
                $($(this).find('i')[0]).toggleClass('down')
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" })
            })
        })
    </script>
@endsection
