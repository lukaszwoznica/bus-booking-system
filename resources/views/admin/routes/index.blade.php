@extends('adminlte::page')

@section('title', 'Routes')

@section('content_header')
    <h1>Routes</h1>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-outline card-indigo elevation-2">
                    <div class="card-header">
                        <h4>Routes manager</h4>
                    </div>

                    <div class="card-body">
                        @include('flash::message')

                        <a href="{{ route('admin.routes.create') }}" class="btn btn-dark mb-3">
                            <i class="fas fa-fw fa-plus"></i>
                            Add route
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Total locations</th>
                                    <th scope="col">Travel duration</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($routes as $route)
                                    <tr>
                                        <th scope="row">{{ $route->id }}</th>
                                        <td>{{ $route->name }}</td>
                                        <td>
                                            {{ $route->locations->count() }}
                                        </td>
                                        <td>
                                            {{ $route->getTravelDuration() }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST"
                                                  id="{{ "delete{$route->id}" }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.routes.show', $route) }}"
                                                   class="btn btn-secondary btn-sm">
                                                    <i class="fas fa-fw fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="{{ route('admin.routes.edit', $route) }}"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                    Edit
                                                </a>
                                                <delete-button form_id='{{ "delete{$route->id}" }}' item_name='route'>
                                                </delete-button>
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
                                    {{ "Showing {$routes->firstItem()} to {$routes->lastItem()} of {$routes->total()} entries"  }}
                                </span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{ $routes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
