<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seller;
use Faker\Generator as Faker;

$factory->define(Seller::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'last_name'=>$faker->lastName,
        'ci'=>$faker->numberBetween($min=2300349640, $max=9999999999),
    ];
});
