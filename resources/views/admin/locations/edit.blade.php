@extends('adminlte::page')

@section('title', 'Edit location')

@section('content_header')
    <h1>Locations</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Edit location</h4>
                    </div>

                    <form action="{{ route('admin.locations.update', $location) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Location name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $location->name) }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer row justify-content-center">
                            <div class="col-5">
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
