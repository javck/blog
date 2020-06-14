<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'owner_id' => function(){
            return factory(\App\User::class)->create()->id;
        },
        'description' => $faker->paragraph
    ];
});
