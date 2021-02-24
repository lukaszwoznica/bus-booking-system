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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group mx-4">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" name="email" required autocomplete="email"
                                       class="form-control input-dark @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-flex justify-content-center mt-4">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Send reset link
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
