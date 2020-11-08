@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New user</div>

                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="first-name">First name</label>
                                <input type="text" name="first_name" id="first-name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name') }}" required autofocus>

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
                                       value="{{ old('last_name') }}" required>

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
                                       value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       value="{{ old('password') }}" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>Roles</label>
                                @foreach($roles as $role)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                               id="{{ "$role->name-role" }}"
                                               class="custom-control-input @error('roles') is-invalid @enderror">
                                        <label class="custom-control-label" for="{{ "$role->name-role" }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach

                                @error('roles')
                                    <span class="invalid-feedback" style="display: block" role="alert">
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
