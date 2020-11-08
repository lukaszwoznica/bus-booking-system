@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Users list</div>

                    <div class="card-body">
                        @include('flash::message')

                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
                            Add user
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">First name</th>
                                    <th scope="col">Last name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Join date</th>
                                    <th scope="col">Roles</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            {{ $user->roles->pluck('name')->implode(', ') }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                   class="btn btn-sm btn-success">Edit</a>
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex">
                            <div class="col-6">
                                <span>
                                    {{ "Showing {$users->firstItem()} to {$users->lastItem()} of {$users->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
