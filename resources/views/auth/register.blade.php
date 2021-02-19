@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 mt-5">
                <div class="card card-transparent text-white">
                    <div class="card-header text-center">
                        <h3 class="m-0">Create new account</h3>
                    </div>

                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="first-name" type="text"
                                           class="form-control @error('first-name') is-invalid @enderror"
                                           name="first-name" value="{{ old('first-name') }}" required
                                           autocomplete="first-name" autofocus placeholder="First name">
                                </div>

                                @error('first-name')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="last-name" type="text"
                                           class="form-control @error('last-name') is-invalid @enderror"
                                           name="last-name" value="{{ old('last-name') }}"
                                           required autocomplete="last-name" placeholder="Last name">
                                </div>

                                @error('last-name')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
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
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password" placeholder="Password">
                                </div>

                                @error('password')
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
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="Confirm password">
                                </div>
                            </div>

                            <div class="form-group row mb-2 mt-5">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
