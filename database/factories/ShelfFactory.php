<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Shelf::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'name' => $faker->word,
        'handle' => function(array $shelf) {
            return str_replace(' ', '-', strtolower($shelf['name']));
        }
    ];
});
