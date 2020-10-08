<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'product_id'=>$faker->numberBetween($min=1, $max=100),
        'payment_method'=>$faker->numberBetween($min=1, $max=3),
        'value'=>$faker->randomFloat($min=2, $max=100, $nbMaxDecimals = 2),
    ];
});
