@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit route: {{ $route->name }}</div>

                    <div class="card-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>

                        <form action="{{ route('admin.routes.update', $route) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Route name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $route->name) }}" required autofocus>
                            </div>

                            <route-locations-inputs :route='{{ $route }}' :locations='@json($locations)'>
                            </route-locations-inputs>

                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
