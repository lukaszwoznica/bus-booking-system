<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::all();

        return view('admin.rides.index', compact('rides'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Ride $ride)
    {
        //
    }

    public function edit(Ride $ride)
    {
        //
    }

    public function update(Request $request, Ride $ride)
    {
        //
    }

    public function destroy(Ride $ride)
    {
        //
    }
}
