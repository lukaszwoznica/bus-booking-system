<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Route\RouteRequest;
use App\Http\Resources\Location as LocationResource;
use App\Location;
use App\Route;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('locations')->paginate(15);

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $locations = Location::all()->sortBy('name');

        return view('admin.routes.create', [
            'locations' => LocationResource::collection($locations)
        ]);
    }

    public function store(RouteRequest $request)
    {
        $route = Route::create($request->validated());

        collect($request->locations)
            ->each(function ($location, $order) use ($route) {
                $route->locations()->attach($location['id'], [
                    'order' => $order,
                    'minutes_from_departure' => $location['minutes'] ?? 0
                ]);
            });

        session()->flash('status', 'The route has been successfully created.');

        return redirect()->route('admin.routes.index');
    }

    public function show(Route $route)
    {
        $route->load('locations');

        return view('admin.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        $route->load('locations');
        $locations = Location::all()->sortBy('name');

        return view('admin.routes.edit', [
            'route' => $route,
            'locations' => LocationResource::collection($locations)
        ]);
    }

    public function update(RouteRequest $request, Route $route)
    {
        $route->update($request->validated());

        $route->locations()->detach();
        collect($request->locations)
            ->each(function ($location, $order) use ($route) {
                $route->locations()->attach($location['id'], [
                    'order' => $order,
                    'minutes_from_departure' => $location['minutes'] ?? 0
                ]);
            });

        session()->flash('status', 'The route has been successfully updated.');

        return redirect()->route('admin.routes.index');
    }

    public function destroy(Route $route)
    {
        try {
            $route->delete();
            session()->flash('status', 'The route has been successfully deleted.');
        } catch (\Exception $e) {
            session()->flash('status', 'An error occurred while deleting the route.');
        }

        return redirect()->route('admin.routes.index');
    }
}
