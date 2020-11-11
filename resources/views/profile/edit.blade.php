@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Edit profile</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                    <a data-toggle="pill" href="#v-pills-profile-info" role="tab"
                                       class="nav-link {{ ! $errors->hasAny(['password', 'current_password']) ? 'active' : ''}}">
                                        Profile information
                                    </a>
                                    <a class="nav-link {{ $errors->hasAny(['password', 'current_password']) ? 'active' : ''}}"
                                       data-toggle="pill" href="#v-pills-password" role="tab">
                                        Change password
                                    </a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content">
                                    <div id="v-pills-profile-info" role="tabpanel"
                                         class="tab-pane fade {{ ! $errors->hasAny(['password', 'current_password']) ? 'show active' : ''}}">
                                        <form action="{{ route('profile.update', auth()->user()) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-group">
                                                <label for="first-name">First name</label>
                                                <input type="text" name="first_name" id="first-name"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       value="{{ old('first_name', auth()->user()->first_name) }}"
                                                       required autofocus>

                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="last-name">Last name</label>
                                                <input type="text" name="last_name" id="last-name"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       value="{{ old('last_name', auth()->user()->last_name) }}"
                                                       required>

                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       value="{{ old('email', auth()->user()->email) }}" required>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                Save
                                            </button>
                                        </form>
                                    </div>
                                    <div id="v-pills-password" role="tabpanel"
                                         class="tab-pane fade {{ $errors->hasAny(['password', 'current_password']) ? 'show active' : ''}}">
                                        <form action="{{ route('profile.update-password', auth()->user()) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-group">
                                                <label for="current-password">Current password</label>
                                                <input type="password" name="current_password" id="current-password"
                                                       class="form-control @error('current_password') is-invalid @enderror">

                                                @error('current_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password">New password</label>
                                                <input type="password" name="password" id="password"
                                                       class="form-control @error('password') is-invalid @enderror">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm">Confirm password</label>
                                                <input type="password" name="password_confirmation"
                                                       id="password-confirm"
                                                       class="form-control">
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                Save
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
