@extends('adminlte::page')

@section('title', 'Edit user')

@section('content_header')
    <h1>Users</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-outline card-primary elevation-2">
                    <div class="card-header">
                        <h4>Edit user</h4>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        <div class="card-body">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="first-name">First name</label>
                                <input type="text" name="first_name" id="first-name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name', $user->first_name) }}" required autofocus>

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
                                       value="{{ old('last_name', $user->last_name) }}" required>

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
                                       value="{{ old('email', $user->email) }}" required>

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
                                       value="{{ old('password') }}">

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
                                               class="custom-control-input @error('roles') is-invalid @enderror"
                                            {{ $user->hasRole($role->name) ? 'checked': '' }}>
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
                        </div>
                        <div class="card-footer row justify-content-center">
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
