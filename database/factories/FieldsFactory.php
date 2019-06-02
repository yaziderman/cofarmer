<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Fields;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(Fields::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'area' => $faker->numberBetween(200,5000),
        'crops_type' => $faker->sentence(5),
    ];
});