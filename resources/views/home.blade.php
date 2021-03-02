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
                                    <div class="form-group position-relative">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <input name="date" id="date" placeholder="Date"
                                                   class="form-control @error('date') is-invalid @enderror"
                                                   value="{{ old('date') }}"
                                                   required>
                                        </div>
                                        @error('date')
                                            <span class="text-danger position-absolute" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
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


@section('scripts')
    <script>
        window.addEventListener('load', function () {
            flatpickr('#date', {
                allowInput: true,
                altInput: true,
                monthSelectorType: 'static',
                altFormat: 'd M Y',
                altInputClass: 'form-control datepicker',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                position: 'auto left',
                locale: {
                    firstDayOfWeek: 1
                },
            });
        })
    </script>
@endsection
