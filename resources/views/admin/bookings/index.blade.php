@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Bookings list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Ride</th>
                                <th scope="col">User</th>
                                <th scope="col">Travel date</th>
                                <th scope="col">Route</th>
                                <th scope="col">Seats</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <th scope="row">{{ $booking->id }}</th>
                                    <td>{{ $booking->ride->id }}</td>
                                    <td>{{ $booking->user->getFullName() }}</td>
                                    <td>{{ $booking->travel_date->format('d.m.Y') }}</td>
                                    <td>
                                        {{ "{$booking->startLocation->name} -> {$booking->endLocation->name}" }}
                                    </td>
                                    <td>{{ $booking->seats }}</td>
                                    <td>{{ ucwords($booking->status) }}</td>
                                    <td>
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-dark">
                                                Update status
                                            </a>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex">
                            <div class="col-6">
                                <span>
                                    {{ "Showing {$bookings->firstItem()} to {$bookings->lastItem()} of {$bookings->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
