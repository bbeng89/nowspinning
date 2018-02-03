<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'turntable' => $faker->words(3, true),
        'turntable_cartridge' => $faker->words(3, true),
        'cd_player' => $faker->words(3, true),
        'tape_deck' => $faker->words(3, true),
        'amp_receiver' => $faker->words(3, true),
        'preamp' => $faker->words(3, true),
        'speakers' => $faker->words(3, true),
        'subwoofer' => $faker->words(3, true),
        'other' => $faker->words(3, true)
    ];
});
