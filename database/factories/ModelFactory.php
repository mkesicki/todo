<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Users;
use App\Categories;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Users::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'password' => Hash::make("123445678"),
        'firstname' => $faker->firstname,
        'lastname' => $faker->name,
        "gender"=> "male",
        "phone"=> $faker->phoneNumber,
        "birthdate"=> $faker->date
    ];
});

$factory->define(Categories::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
    ];
});