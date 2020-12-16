@extends('adminlte::page')

@section('title', 'Bookings')

@section('content_header')
    <h1>Bookings</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4 >Bookings manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
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
                                            <form action="{{ route('admin.bookings.destroy', $booking) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.bookings.edit', $booking) }}"
                                                   class="btn btn-sm btn-success">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                    Update status
                                                </a>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-fw fa-trash-alt"></i>
                                                    Delete
                                                </button>
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
