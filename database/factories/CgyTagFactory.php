<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CgyTag;
use Faker\Generator as Faker;

$factory->define(CgyTag::class, function (Faker $faker) {
    return [
        'cgy_id' => rand(1,10),
        'tag_id' => rand(1,10),
        'description' => $faker->paragraph
    ];
});
