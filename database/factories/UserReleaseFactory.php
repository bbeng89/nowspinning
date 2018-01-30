<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserRelease::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'discogs_id' => $faker->randomNumber(6),
        'discogs_folder_id' => $faker->randomNumber(6),
        'artists' => '[{"id": 271475, "name": "Accept", "resourceUrl": "https://api.discogs.com/artists/271475"}]',
        'artists_display' => function(array $userRelease){
            return collect(json_decode($userRelease['artists']))->map(function($item){
                return $item->name;
            })->implode(", ");
        },
        'title' => $faker->sentence(),
        'release_year' => $faker->year(),
        'date_added' => \Carbon\Carbon::now(),
        'thumbnail' => 'http://placehold.it/250x250',
        'cover_image' => 'http://placehold.it/500x500',
        'discogs_url' => '',
        'listen_count' => 0,
    ];
});
