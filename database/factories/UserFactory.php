<?php

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'prenom' => $faker->lastName,
        'login' => $faker->unique()->login,
        'telephone' => $faker->e164PhoneNumber,
        'sexe' => $faker->title($gender = null|'Homme'|'femme'),
        'lieu_naissance' => $faker->streetName,
        'date_naissance' => now(),
        'password' => bcrypt('aaaaaa'),
        'remember_token' => Str::random(10),
    ];
});
