<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Jargon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Jargon::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->text()
    ];
});