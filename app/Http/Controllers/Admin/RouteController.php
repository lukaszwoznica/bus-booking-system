<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RouteRequest;
use App\Location;
use App\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(RouteRequest $request)
    {

        dd($request->validated());
        $route = Route::create($request->validated());

        collect($request->locations)
            ->each(function ($location, $order) use ($route) {
                $route->locations()->attach($location['id'], [
                    'order' => $order,
                    'minutes_from_departure' => $location['minutes'] ?? 0
                ]);
            });

        return redirect()->route('admin.routes.index');
    }

    public function show(Route $route)
    {
        //
    }

    public function edit(Route $route)
    {
        //
    }

    public function update(Request $request, Route $route)
    {
        //
    }

    public function destroy(Route $route)
    {
        //
    }
}
