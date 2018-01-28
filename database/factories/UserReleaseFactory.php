<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserRelease::class, function (Faker $faker) {
    return [
        'user_id' => '',
        'discogs_id' => '',
        'discogs_folder_id' => '',
        'artists' => '',
        'artists_display' => '',
        'title' => '',
        'release_year' => '',
        'date_added' => '',
        'thumbnail' => '',
        'cover_image' => '',
        'discogs_url' => '',
        'listen_count' => '',
    ];
});
