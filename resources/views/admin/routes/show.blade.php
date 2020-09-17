@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Route details</div>

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
                                <ul>
                                    @foreach($route->locations as $location)
                                        <li>
                                            {{ "$location->name : {$location->minutesFromDepartureFormatted()}" }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
