@extends('layouts.app')

@section('inactive-account-alert')
    @include('partials.inactive-account-alert')
@endsection

@section('content')
    <div class="container">
        <header class="d-flex align-items-center justify-content-center">
            <h1 class="text-center mb-3 text-white font-weight-light align-middle">
                Search for bus rides
            </h1>
        </header>

        <div class="row justify-content-center align-items-center">
            <div class="col-sm-12">
                <div class="card card-transparent py-2">
                    <div class="card-body">
                        <form action="{{ route('rides.index') }}" method="GET">
                            <div class="form-row align-items-center justify-content-center">
                                <div class="col-sm-12 col-md-4 col-lg-3 col-xl-4">
                                    <autocomplete-input
                                        :items='@json($locations)'
                                        :error="'{{ $errors->first("start_location") }}'"
                                        :name="'start_location'"
                                        :id="'start-location'"
                                        :placeholder="'From'"
                                        :prepend_icon="'fas fa-map-marker-alt'"
                                        :old="'{{ old('start_location') }}'"
                                        :required="true">
                                    </autocomplete-input>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-3 col-xl-4">
                                    <autocomplete-input
                                        :items='@json($locations)'
                                        :error="'{{ $errors->first("end_location") }}'"
                                        :name="'end_location'"
                                        :id="'end-location'"
                                        :placeholder="'To'"
                                        :prepend_icon="'fas fa-map-marker-alt'"
                                        :old="'{{ old('end_location') }}'"
                                        :required="true">
                                    </autocomplete-input>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </div>
                                            </div>
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
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block btn-o">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
