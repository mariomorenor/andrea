<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Income;
use Faker\Generator as Faker;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'time'=>$faker->time($format = 'H:i:s'),
        'user_id'=>$faker->numberBetween($min=1,$max=2),
        'quantity'=>$faker->randomDigit
    ];
});
