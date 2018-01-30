<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Shelf;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDefaultUserShelves
{
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
        $shelves = config('constants.default_shelves');
        $user = $event->getUser();

        foreach($shelves as $handle => $name)
        {
            Shelf::create([
                'user_id' => $user->id,
                'name' => $name,
                'handle' => $handle
            ]);
        }
    }
}
