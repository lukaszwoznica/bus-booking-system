@extends('adminlte::page')

@section('title', 'Locations')

@section('content_header')
    <h1>Locations</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Locations manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <a href="{{ route('admin.locations.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i>
                            Add location
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
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
                                            <form action="{{ route('admin.locations.destroy', $location) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.locations.edit', $location) }}"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                    Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-fw fa-trash-alt"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex">
                            <div class="col-6">
                                <span>
                                    {{ "Showing {$locations->firstItem()} to {$locations->lastItem()} of {$locations->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $locations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
