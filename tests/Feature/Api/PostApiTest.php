<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function testRetrievingGlobalPosts()
    {
        $numPosts = 5;
        // 10 different posts, 10 different users
        factory(\App\Models\Post::class, $numPosts)->create();
        $user = User::first();
        $this->actingAs($user, 'api')
            ->get('/api/posts/global')
            ->assertJsonCount($numPosts, 'data');
    }

    public function testRetrievingFriendPosts()
    {
        // 10 different posts, 10 different users
        factory(\App\Models\Post::class, 5)->create();
        $user = User::first();

        // right now friends aren't setup so it should only return posts for the current user
        $this->actingAs($user, 'api')
            ->get('/api/posts/friends')
            ->assertJsonCount(1, 'data');
    }

    public function testInvalidFeed()
    {
        // 10 different posts, 10 different users
        factory(\App\Models\Post::class)->create();
        $user = User::first();
        $this->actingAs($user, 'api')
            ->get('/api/posts/test')
            ->assertStatus(404);

        $this->actingAs($user, 'api')
            ->get('/api/posts')
            ->assertStatus(404);
    }

    public function testPostPagination()
    {
        $numPages = 2;
        $pageSize = 5;
        $numItems = $pageSize * $numPages;

        factory(\App\Models\Post::class, $numItems)->create();
        $user = User::first();

        $this->actingAs($user, 'api')
            ->get("/api/posts/global?per_page={$pageSize}")
            ->assertJsonCount($pageSize, 'data')
            ->assertJson([
                'total' => $numItems,
                'current_page' => 1,
                'from' => 1,
                'to' => $pageSize,
                'per_page' => $pageSize,
                'last_page' => $numPages
            ]);
    }

    public function testCreatingPostWithoutShowingNowSpinning()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->actingAs($user, 'api')
            ->post('/api/posts/create', ['content' => 'Hello World'])
            ->assertSuccessful()
            ->assertJson([
                'user_id' => $user->id,
                'content' => 'Hello World',
                'user_release_id' => null
            ]);
    }

    public function testCreatingPostWithShowingNowSpinning()
    {
        $release = factory(\App\Models\UserRelease::class)->create();
        $user = $release->user;
        $user->now_spinning_id = $release->id;
        $user->save();

        $this->actingAs($user, 'api')
            ->post('/api/posts/create', ['content' => 'Hello World', 'showSpinning' => 'true'])
            ->assertSuccessful()
            ->assertJson([
                'user_id' => $user->id,
                'content' => 'Hello World',
                'user_release_id' => $release->id
            ]);
    }
}
