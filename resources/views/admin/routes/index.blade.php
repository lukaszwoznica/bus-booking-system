@extends('adminlte::page')

@section('title', 'Routes')

@section('content_header')
    <h1>Routes</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Routes manager</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.routes.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i> Add new route
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
