@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <h4 class="m-0">
                            Confirm password
                        </h4>
                    </div>

                    <div class="card-body">
                        <p>{{ __('Please confirm your password before continuing.') }}</p>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group mx-5">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" name="password"
                                       class="form-control input-dark @error('password') is-invalid @enderror"
                                       required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-center mt-4">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Confirm password
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
