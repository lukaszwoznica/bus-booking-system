@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New bus</div>

                    <div class="card-body">
                        <form action="{{ route('admin.buses.store') }}" method="POST">
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
