<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Prescriber::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'npi' => $faker->numberBetween(1000000000,9999999999),
        'phone' => $faker->numberBetween(1000000000,9999999999),
        'phone_extension' => $faker->numberBetween(1000,9999),
        'fax'=> $faker->numberBetween(1000000000,9999999999),
        'role'=> 'prescriber',
        'is_admin' => false,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});
