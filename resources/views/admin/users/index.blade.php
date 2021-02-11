@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Users manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        @can('create', App\User::class)
                            <a href="{{ route('admin.users.create') }}" class="btn btn-dark mb-3">
                                <i class="fas fa-fw fa-plus"></i>
                                Add user
                            </a>
                        @endcan

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">First name</th>
                                    <th scope="col">Last name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Join date</th>
                                    <th scope="col">Verified</th>
                                    <th scope="col">Roles</th>
                                    @can('updateOrDeleteAny', \App\User::class)
                                        @php $canUpdateOrDelete = true; @endphp
                                        <th scope="col">Actions</th>
                                    @else
                                        @php $canUpdateOrDelete = false; @endphp
                                    @endcan
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
                                        <td>{{ $user->hasVerifiedEmail() ? 'Yes' : 'No' }}</td>
                                        <td>
                                            {{ $user->roles->pluck('name')->implode(', ') }}
                                        </td>
                                        @if($canUpdateOrDelete)
                                            <td>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                      id="{{ "delete{$user->id}" }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                       class="btn btn-sm btn-success">
                                                        <i class="fas fa-fw fa-edit"></i>
                                                        Edit
                                                    </a>
                                                    @if(Auth::user()->id != $user->id)
                                                        <delete-button form_id='{{ "delete{$user->id}" }}' item_name='user'>
                                                        </delete-button>
                                                    @endif
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

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


