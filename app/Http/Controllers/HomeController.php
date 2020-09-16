<?php

namespace App\Http\Controllers;

use App\Http\Resources\Location as LocationResource;
use App\Location;

class HomeController extends Controller
{
    public function index()
    {
        $locations = Location::all()->sortBy('name');

        return view('home', [
            'locations' => LocationResource::collection($locations)
        ]);
    }
}
