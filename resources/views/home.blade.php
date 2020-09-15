@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Homepage') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('rides.index') }}" method="GET">
                            <div class="form-group">
                                <label for="start-location">From</label>
                                <input type="text" name="start_location" id="start-location" autofocus
                                       class="form-control @error('start_location') is-invalid @enderror" required >

                                @error('start_location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end-location">To</label>
                                <input type="text" name="end_location" id="end-location"
                                       class="form-control @error('end_location') is-invalid @enderror" required>

                                @error('end_location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date">Departure date</label>
                                <input type="date" name="date" id="date"
                                       class="form-control @error('date') is-invalid @enderror" required>

                                @error('date')
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
