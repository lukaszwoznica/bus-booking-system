@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New location</div>

                    <div class="card-body">
                        <form action="{{ route('admin.locations.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Locality name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

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
