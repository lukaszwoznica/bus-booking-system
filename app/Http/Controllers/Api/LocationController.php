<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;
use App\Http\Resources\Location as LocationResource;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all()->sortBy('name');

        return LocationResource::collection($locations);
    }
}
