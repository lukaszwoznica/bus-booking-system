@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.bookings.index', ['status' => 'new']) }}" class="text-dark">
                    <div class="info-box elevation-2">
                        <span class="info-box-icon bg-blue"><i class="far fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">New bookings</span>
                            <span class="info-box-number">{{ $newBookings }}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.rides.index', ['state' => 'active']) }}" class="text-dark">
                    <div class="info-box elevation-2">
                        <span class="info-box-icon bg-red"><i class="fas fa-road"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active rides</span>
                            <span class="info-box-number">{{ $activeRides }}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.routes.index') }}" class="text-dark">
                    <div class="info-box elevation-2">
                        <span class="info-box-icon bg-green"><i class="fas fa-route"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total routes</span>
                            <span class="info-box-number">{{ $totalRoutes }}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a href="{{ route('admin.users.index') }}" class="text-dark">
                    <div class="info-box elevation-2">
                        <span class="info-box-icon bg-maroon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Registered users</span>
                            <span class="info-box-number">{{ $registeredUsers }}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 col-lg-7 col-xl-8 mb-4">
                <div class="card card-outline card-indigo elevation-2 h-100">
                    <div class="card-header">
                        <h4 class="card-title">Bookings in last 6 months</h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <bar-chart :chartdata='@json($bookingsByMonthData)'></bar-chart>
                    </div>
                    <div class="card-footer row">
                        <div class="col-4 text-center">
                            <h5 class="mb-0 d-flex align-items-center justify-content-center">
                                @if($bookingsByMonthData['stats']['percentageChange'] < 0)
                                    <i class="fas fa-caret-down text-danger"></i>
                                @elseif($bookingsByMonthData['stats']['percentageChange'] > 0)
                                    <i class="fas fa-caret-up  text-success"></i>
                                @else
                                    <i class="fas fa-caret-left text-warning"></i>
                                @endif
                                <strong class="ml-1">
                                    {{ abs($bookingsByMonthData['stats']['percentageChange']) }}%
                                </strong>
                            </h5>
                            <span class="">From last month</span>
                        </div>
                        <div class="col-4 text-center">
                            <h5 class="mb-0">
                                <strong>
                                    {{ $bookingsByMonthData['stats']['total'] }}
                                </strong>
                            </h5>
                            <span class="">Total bookings</span>
                        </div>
                        <div class="col-4 text-center">
                            <h5 class="mb-0">
                                <strong>
                                    {{ $bookingsByMonthData['stats']['avg'] }}
                                </strong>
                            </h5>
                            <span class="">Monthly average</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 col-xl-4 mb-4">
                <div class="card card-outline card-indigo elevation-2 h-100">
                    <div class="card-header">
                        <h4 class="card-title">Routes with most active rides</h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <doughnut-chart :chartdata='@json($ridesByRouteData)'></doughnut-chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
