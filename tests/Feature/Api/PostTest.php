<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRetrievingGlobalPosts()
    {
        $user = factory(\App\Models\User::class)->create();
        $post = factory(\App\Models\Post::class)->create(['user_id' => $user->id]);
        $this->actingAs($user, 'api');
        $this->get('/api/posts/global')->assertJsonCount(1, 'data');
        // todo - create posts from multiple users and test they all show up
    }
}
