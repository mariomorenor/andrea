<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    
    return [
        'name'=>$faker->word,
        'description'=>$faker->text($maxNbChars = 200),
        'code'=>$faker->word.$faker->numberBetween($min= 5000, $max=9999),
        'price'=>$faker->randomFloat($min= 1, $max=999, $nbMaxDecimals=2),
    ];
});


