@extends('layouts.app')

@section('inactive-account-alert')
    @include('partials.inactive-account-alert')
@endsection

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

                            <autocomplete-input
                                :items='@json($locations)'
                                :error="'{{ $errors->first("start_location") }}'"
                                :name="'start_location'"
                                :id="'start-location'"
                                :label="'From'"
                                :old="'{{ old('start_location') }}'"
                                :required="true">
                            </autocomplete-input>

                            <autocomplete-input
                                :items='@json($locations)'
                                :error="'{{ $errors->first("end_location") }}'"
                                :name="'end_location'"
                                :id="'end-location'"
                                :label="'To'"
                                :old="'{{ old('end_location') }}'"
                                :required="true">
                            </autocomplete-input>

                            <div class="form-group">
                                <label for="date">Departure date</label>
                                <input type="date" name="date" id="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       value="{{ old('date') }}"
                                       required>

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
