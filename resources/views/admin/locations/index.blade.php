@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Locations list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary mb-3">
                            Add location
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $location)
                                    <tr>
                                        <th scope="row">{{ $location->id }}</th>
                                        <td>{{ $location->name }}</td>
                                        <td>
                                            <form action="{{ route('admin.locations.destroy', $location) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.locations.edit', $location) }}"
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
