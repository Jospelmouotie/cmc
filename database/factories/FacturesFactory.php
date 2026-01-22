<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Facture::class, function (Faker $faker) {
    return [
        'numero' => mt_rand(1000, 99999),
    ];
});
