<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'email'=>$fake->unique()->safeEmail,
        'address'=>$fake->address,
        'Phone'=>$fake->phone,
    ];
});
