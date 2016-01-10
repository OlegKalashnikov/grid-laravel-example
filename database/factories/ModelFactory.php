<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\UserCompany::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $companies = \App\UserCompany::query()->lists('id');
    $now = \Carbon\Carbon::now();
    $created_seconds = mt_rand(-730 * 24 * 60 * 60, 0);
    $created_at = clone $now;
    $created_at->addSeconds($created_seconds);
    $updated_at = clone $created_at;
    $updated_at->addSeconds(mt_rand($created_seconds, 0) * -1);
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'company_id' => count($companies) ? $companies[mt_rand(0, count($companies) - 1)] : null,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
});
