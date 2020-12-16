@extends('adminlte::page')

@section('title', 'Add route')

@section('content_header')
    <h1>Routes</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Create new route</h4>
                    </div>

                    <form action="{{ route('admin.routes.store') }}" method="POST">
                        <div class="card-body">
                            @csrf

                            @if($errors->isNotEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Route name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required autofocus>
                            </div>

                            <route-locations-inputs :locations='@json($locations)'></route-locations-inputs>
                        </div>
                        <div class="card-footer row justify-content-center">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
