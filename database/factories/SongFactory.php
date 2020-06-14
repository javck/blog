<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Song;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Song::class, function (Faker $faker) {
    $timestamp = Carbon::now()->addDays(rand(-365, 365));
    return [
            'name' => $faker->sentence($nbWords = 3),
            'published_time' => Carbon::now()->addDays(rand(-30,30)),
            'sell_at' => Carbon::now()->addDays(rand(1,30)),
            'album_id' => $faker->randomDigitNot(0),
            'cgy_id' => rand(1,10),
            'url' => $faker->url,
            'cover' => $faker->imageUrl($width = 640, $height = 480),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
    ];
});
