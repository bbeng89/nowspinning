<?php

namespace Tests\Feature\Event;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEventTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultShelves = [
        'vinyl' => 'Vinyl',
        'cassette' => 'Cassette',
        'cd' => 'CD',
        'heavy-rotation' => 'Heavy Rotation',
        'on-deck' => 'On Deck'
    ];

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDefaultShelvesAreCreated()
    {
        $user = factory(\App\Models\User::class)->create();

        foreach($this->defaultShelves as $handle => $name)
        {
            $shelf = $user->getShelf($handle);
            $this->assertNotNull($shelf);
            $this->assertTrue($shelf->name == $name);
        }
    }
}
