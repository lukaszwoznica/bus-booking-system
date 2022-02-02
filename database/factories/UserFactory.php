<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $gender = Arr::random(['Male', 'Female']);

    return [
        'first_name' => $faker->{"firstName$gender"},
        'last_name' => $faker->{"lastName$gender"},
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$YRacvPG4ZGxRt88Pln1eWuUEMJNFpFtmxneaTld.jnJDNYX1c7Hsa', // BbsPass123
    ];
});
