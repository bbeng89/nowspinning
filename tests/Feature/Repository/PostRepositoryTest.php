<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repositories\PostRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testGlobalNewsFeed()
    {
        $numPosts = 5;
        $posts = factory(\App\Models\Post::class, $numPosts)->create();
        $user = factory(\App\Models\User::class)->create();
        $repo = $this->app->make(PostRepository::class);

        $feed = $repo->getUserNewsFeed('global', $user, $numPosts);
        $this->assertCount($numPosts, $feed);
    }

    public function testFriendNewsFeed()
    {
        $user = factory(\App\Models\User::class)->create();
        $friend = factory(\App\Models\User::class)->create();
        $nonFriend = factory(\App\Models\User::class)->create();
        $user->friends()->attach($friend->id);

        $selfPost = factory(\App\Models\Post::class)->create(['user_id' => $user->id]);
        $friendPost = factory(\App\Models\Post::class)->create(['user_id' => $friend->id]);
        $nonFriendPost = factory(\App\Models\Post::class)->create(['user_id' => $nonFriend->id]);

        $repo = $this->app->make(PostRepository::class);
        $feed = $repo->getUserNewsFeed('friends', $user);

        $this->assertCount(2, $feed);
    }

    public function testInvalidFeed()
    {
        $repo = $this->app->make(PostRepository::class);
        factory(\App\Models\Post::class, 1)->create();
        $user = User::first();

        $feed = $repo->getUserNewsFeed('testfeed', $user);

        $this->assertEmpty($feed);
    }
}
