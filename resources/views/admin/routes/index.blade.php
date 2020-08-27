@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Routes list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('admin.routes.create') }}" class="btn btn-primary mb-3">
                            Add route
                        </a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Locations</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($routes as $route)
                                <tr>
                                    <th scope="row">{{ $route->id }}</th>
                                    <td>{{ $route->name }}</td>
                                    <td>
                                        @foreach($route->locations as $location)
                                            {{ $location->name }}
                                        @endforeach

                                    </td>
                                    <td>
                                        <form action="{{ route('admin.routes.destroy', $route) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.routes.edit', $route) }}"
                                               class="btn btn-success">Edit</a>
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
