<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /**
     Consumer Key	MsbeJIQAcTuTrlVjqofi
    Consumer Secret	EdndQvjzMrntJBDCvhduHxVcFbAzUlNG
    Request Token URL	https://api.discogs.com/oauth/request_token
    Authorize URL	https://www.discogs.com/oauth/authorize
    Access Token URL	https://api.discogs.com/oauth/access_token
     */

    // todo - move these to env vars  env('DISCOGS_KEY') env('DISCOGS_SECRET'), env('DISCOGS_REDIRECT')
    'discogs' => [
        'client_id' => 'MsbeJIQAcTuTrlVjqofi',
        'client_secret' => 'EdndQvjzMrntJBDCvhduHxVcFbAzUlNG',
        'redirect' => 'http://nowspinning.dev/home',
    ]

];
