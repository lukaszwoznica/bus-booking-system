@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="card bg-dark-lighter text-white mt-3">
                    <div class="card-header bg-dark-lightest d-flex">
                        <h4 class="m-0">
                            Reset password
                        </h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group mx-4">
                                <label for="email">E-Mail</label>
                                <input id="email" type="email" name="email"
                                       class="form-control input-dark @error('email') is-invalid @enderror"
                                       value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mx-4">
                                <label for="password">New password</label>
                                <input id="password" type="password" name="password"
                                       class="form-control input-dark @error('password') is-invalid @enderror"
                                       required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group mx-4">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control input-dark"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group d-flex justify-content-center mt-4">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Reset password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
