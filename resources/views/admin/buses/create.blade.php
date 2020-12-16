@extends('adminlte::page')

@section('title', 'Add bus')

@section('content_header')
    <h1>Buses</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Create new bus</h4>
                    </div>

                    <form action="{{ route('admin.buses.store') }}" method="POST">
                        <div class="card-body">
                            @csrf

                            <div class="form-group">
                                <label for="name">Bus name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seats">Number of seats</label>
                                <input type="number" name="seats" id="seats" min="0"
                                       class="form-control @error('seats') is-invalid @enderror"
                                       value="{{ old('seats') }}" required>

                                @error('seats')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer row justify-content-center">
                            <div class="col-5">
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
