@extends('adminlte::page')

@section('title', 'Edit route')

@section('content_header')
    <h1>Routes</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Edit route</h4>
                    </div>

                    <form action="{{ route('admin.routes.update', $route) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            {{--                        <ul>--}}
                            {{--                            @foreach ($errors->all() as $error)--}}
                            {{--                                <li class="text-danger">{{ $error }}</li>--}}
                            {{--                            @endforeach--}}
                            {{--                        </ul>--}}

                            <div class="form-group">
                                <label for="name">Route name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $route->name) }}" required autofocus>
                            </div>

                            <route-locations-inputs :route='{{ $route }}' :locations='@json($locations)'>
                            </route-locations-inputs>
                        </div>
                        <div class="card-footer row justify-content-center">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
