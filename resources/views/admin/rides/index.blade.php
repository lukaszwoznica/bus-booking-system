@extends('adminlte::page')

@section('title', 'Rides')

@section('content_header')
    <h1>Rides</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Rides manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <a href="{{ route('admin.rides.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i>
                            Add ride
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Route</th>
                                    <th scope="col">Bus</th>
                                    <th scope="col">Departure time</th>
                                    <th scope="col">Ride type</th>
                                    <th scope="col">Ride date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rides as $ride)
                                    <tr>
                                        <th scope="row">{{ $ride->id }}</th>
                                        <td>{{ $ride->route->name }}</td>
                                        <td>{{ $ride->bus->name }}</td>
                                        <td>{{ $ride->departure_time->format('H:i' )}}</td>
                                        <td>
                                            {{ $ride->ride_date ? 'Single' : 'Cyclic' }}
                                        </td>
                                        <td>
                                            {{ $ride->ride_date ? $ride->ride_date->format('d.m.Y') : '-' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.rides.destroy', $ride) }}" method="POST"
                                            id="{{ "delete{$ride->id}" }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.rides.edit', $ride) }}"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                    Edit
                                                </a>
                                                <delete-button form_id='{{ "delete{$ride->id}" }}' item_name='ride'>
                                                </delete-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex">
                            <div class="col-6">
                                <span>
                                    {{ "Showing {$rides->firstItem()} to {$rides->lastItem()} of {$rides->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $rides->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
