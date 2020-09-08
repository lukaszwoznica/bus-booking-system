@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">Rides list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('admin.rides.create') }}" class="btn btn-primary mb-3">
                            Add ride
                        </a>

                        <table class="table">
                            <thead>
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
                                            <form action="{{ route('admin.rides.destroy', $ride) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.rides.edit', $ride) }}"
                                                   class="btn btn-success">Edit</a>
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
