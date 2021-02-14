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
                        <h4>Bookings manager</h4>
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-tabs justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link {{ !in_array(request()->get('status'), $bookingStatuses) ? 'active' : ''}}"
                                   href="{{ route('admin.bookings.index') }}">
                                    All
                                </a>
                            </li>
                            @foreach($bookingStatuses as $status)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('status') == $status ? 'active' : '' }}"
                                       href="{{ route('admin.bookings.index', ['status' => $status]) }}">
                                        {{ ucfirst($status) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="table-responsive mt-2">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('adminlte_js')
    {{$dataTable->scripts()}}
@endpush
