<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ride;
use App\RideSchedule;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(RideSchedule::class, function (Faker $faker) {
    $activeDays = collect(Carbon::getDays())->mapWithKeys(function ($day) {
        return [strtolower($day) => true];
    })->toArray();

    return $activeDays + [
        'ride_id' => factory(Ride::class)->state('cyclic'),
        'start_date' => now(),
        'end_date' => null,
    ];
});
