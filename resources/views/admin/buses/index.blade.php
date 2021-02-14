@extends('adminlte::page')

@section('title', 'Buses')

@section('content_header')
    <h1>Buses</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Buses manager</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.buses.create') }}" class="btn btn-dark mb-3 text-right">
                            <i class="fas fa-fw fa-plus"></i> Add new bus
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
