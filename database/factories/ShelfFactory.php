<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Shelf::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'name' => $name,
        'handle' => strtolower($name)
    ];
});
