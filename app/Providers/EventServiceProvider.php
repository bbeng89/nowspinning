<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\Discogs\DiscogsExtendSocialite@handle',
        ],
        \App\Events\UserCreated::class => [
            \App\Listeners\CreateDefaultUserShelves::class
        ],
        \App\Events\UserDiscogsCollectionSynced::class => [
            \App\Listeners\CreateCollectionUpdatePost::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
