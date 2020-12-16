@extends('adminlte::page')

@section('title', 'Route details')

@section('content_header')
    <h1>Routes</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Route details</h4>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th scope="row">Id</th>
                                <td>{{ $route->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ $route->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Locations</th>
                                <td>
                                    <div class="timeline">
                                        @foreach($route->locations as $location)
                                            <div class="time-label">
                                            <span class="{{ $location->pivot->order == 0 ? 'bg-secondary' : 'bg-green' }}">
                                                @if($location->pivot->order == 0)
                                                    Start
                                                @else
                                                    {{ $location->minutesFromDepartureFormatted() }}
                                                @endif
                                            </span>
                                            </div>
                                            <div>
                                                <i class="fas fa-map-marker-alt bg-indigo"></i>
                                                <div class="timeline-item bg-light">
                                                    <h3 class="timeline-header">{{ $location->name }}</h3>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="time-label">
                                            <span class="bg-secondary">End</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
