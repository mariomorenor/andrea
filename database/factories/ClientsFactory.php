<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'last_name'=>$faker->lastName,
        'cedula'=>$faker->numberBetween($min=2300349640, $max=9999999999),
        'email'=>$faker->email,
        'address'=>$faker->address,
        'phone'=>$faker->numberBetween($min=2300349640, $max=9999999999)
    ];
});
