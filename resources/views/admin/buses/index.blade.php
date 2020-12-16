@extends('adminlte::page')

@section('title', 'Buses')

@section('content_header')
    <h1>Buses</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Buses manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <a href="{{ route('admin.buses.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i>
                            Add bus
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Seats</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($buses as $bus)
                                    <tr>
                                        <th scope="row">{{ $bus->id }}</th>
                                        <td>{{ $bus->name }}</td>
                                        <td>{{ $bus->seats }}</td>
                                        <td>
                                            <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.buses.edit', $bus) }}"
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
                                    {{ "Showing {$buses->firstItem()} to {$buses->lastItem()} of {$buses->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $buses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
