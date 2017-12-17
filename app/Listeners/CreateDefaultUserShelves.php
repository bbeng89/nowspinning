<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Shelf;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultUserShelves
{
    protected $defaultShelves = [
        'vinyl' => 'Vinyl',
        'cassette' => 'Cassette',
        'cd' => 'CD',
        'heavy-rotation' => 'Heavy Rotation',
        'on-deck' => 'On Deck'
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->getUser();
        foreach($this->defaultShelves as $handle => $name)
        {
            Shelf::create([
                'user_id' => $user->id,
                'name' => $name,
                'handle' => $handle
            ]);
        }
    }
}
