<?php

namespace Tests\Feature\Event;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class UserEventTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultShelvesAreCreated()
    {
        $shelves = config('constants.default_shelves');
        $user = factory(\App\Models\User::class)->create();

        foreach($shelves as $handle => $name)
        {
            $shelf = $user->getShelf($handle);
            $this->assertNotNull($shelf);
            $this->assertTrue($shelf->name == $name);
        }
    }

    // note - the actual functionality of this event will be tested in a unit test
    public function testCollectionUpdatePostEventFired()
    {
        // todo
    }
}
