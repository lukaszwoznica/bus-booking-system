@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 mt-5">
                <div class="card card-transparent text-white">
                    <div class="card-header text-center">
                        <h3 class="m-0">Login</h3>
                    </div>

                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus placeholder="Email">
                                </div>

                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password"
                                           placeholder="Password">
                                </div>

                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row align-items-center mt-0">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-2 mt-4">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row mt-4 mb-0">
                                <div class="col-12 d-flex justify-content-center">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                           class="text-white text-decoration-none">
                                            Forgot Your Password?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
