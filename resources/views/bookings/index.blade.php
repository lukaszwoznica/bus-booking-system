@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <div class="col-sm-7">
                            <h4 class="m-0">
                                My bookings
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <div class="table-responsive">
                            <table class="table text-white">
                                <thead>
                                <tr>
                                    <th scope="col">Route</th>
                                    <th scope="col">Travel date</th>
                                    <th scope="col">Seats</th>
                                    <th scope="col">Made at</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>
                                            {{ $booking->startLocation->name }}
                                            <i class="fas fa-arrow-right mx-2"></i>
                                            {{ $booking->endLocation->name }}
                                        </td>
                                        <td>{{ $booking->travel_date->format('d M Y') }}</td>
                                        <td>{{ $booking->seats }}</td>
                                        <td>{{ $booking->created_at->format('d m Y H:i') }}</td>
                                        <td>{{ ucwords($booking->status) }}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary">
                                                Show details
                                            </a>
                                        </td>
{{--                                        <td>--}}
{{--                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                @method('PATCH')--}}
{{--                                                <button class="btn btn-sm btn-danger"--}}
{{--                                                    {{ !$booking->canBeCancelled() ? 'disabled' : ''}}>--}}
{{--                                                    Cancel booking--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div>
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
