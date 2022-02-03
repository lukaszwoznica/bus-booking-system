<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use App\BookingStatus;
use App\Ride;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    $ride = Ride::inRandomOrder()->with('route.locations')->first();

    $totalLocations = $ride->route->locations->count();
    $startLocation = $ride->route->locations
        ->take($totalLocations / 2)
        ->random();
    $endLocation = $ride->route->locations
        ->where('pivot.order', '>', $startLocation->pivot->order)
        ->random();

    $travelStartTime = $ride->departure_time->addMinutes($startLocation->pivot->minutes_from_departure);
    $rideStartDate = $ride->isCyclic()
        ? $faker->dateTimeBetween('-5 months', '+1 months')
        : $ride->ride_date;
    $travelDate = $ride->departure_time->isSameDay($travelStartTime)
        ? $rideStartDate
        : Carbon::parse($rideStartDate)->addDay();

    $bookingStatus = collect(BookingStatus::getKeys())
        ->map(fn($status) => strtolower($status))
        ->random();

    $rideDateDaysDiff = now()->diffInDays($rideStartDate, false);
    $timestampEndLimit = $rideDateDaysDiff <= 0 ? $rideDateDaysDiff - 1 : 0;
    $timestampStartLimit = $timestampEndLimit - 100;
    $timestamp = $faker->dateTimeBetween("$timestampStartLimit days", "$timestampEndLimit days");

    return [
        'ride_id' => $ride->id,
        'user_id' => User::select('id')->inRandomOrder()->first(),
        'travel_date' => $travelDate,
        'ride_start_date' => $rideStartDate,
        'start_location_id' => $startLocation->id,
        'end_location_id' => $endLocation->id,
        'seats' => rand(1, 3),
        'status' => $bookingStatus,
        'created_at' => $timestamp,
        'updated_at' => $timestamp
    ];
});
