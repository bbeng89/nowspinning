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
        $numPosts = 5;
        factory(\App\Models\Post::class, $numPosts)->create();
        $user = User::first();
        $repo = $this->app->make(PostRepository::class);

        $feed = $repo->getUserNewsFeed('friends', $user, $numPosts);
        $this->assertCount(1, $feed);
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
