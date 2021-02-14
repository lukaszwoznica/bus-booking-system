@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Users manager</h4>
                    </div>

                    <div class="card-body">
                        @can('create', App\User::class)
                            <a href="{{ route('admin.users.create') }}" class="btn btn-dark mb-3">
                                <i class="fas fa-fw fa-plus"></i>
                                Add new user
                            </a>
                        @endcan

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
