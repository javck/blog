<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cgy;
use Faker\Generator as Faker;

$factory->define(Cgy::class, function (Faker $faker) {
    return [
        'title' =>  $faker->sentence,
        'desc' => $faker->paragraph,
        'enabled' => rand(0,1)
    ];
});
