@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Rides list</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('admin.rides.create') }}" class="btn btn-primary mb-3">
                            Add ride
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>

                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rides as $ride)
                                    <tr>
                                        <th scope="row">{{ $ride->id }}</th>

                                        <td>
                                            <form action="{{ route('admin.rides.destroy', $ride) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.rides.edit', $ride) }}"
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
