@extends('adminlte::page')

@section('title', 'Locations')

@section('content_header')
    <h1>Locations</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Locations manager</h4>
                    </div>

                    <div class="card-body" id="hehe">
                        <a href="{{ route('admin.locations.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i> Add new location
                        </a>
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
