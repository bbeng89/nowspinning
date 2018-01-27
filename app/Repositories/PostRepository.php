<?php namespace App\Repositories;

use App\Models\User;
use App\Models\Post;

class PostRepository
{
    const NEWS_FEED_PAGE_SIZE = 50;

    public function getUserNewsFeed($feed, User $user)
    {
        if($feed == 'global')
        {
            $query = Post::query();
        }
        else
        {
            //todo - change this logic once friends are implemented
            $query = Post::where('user_id', $user->id);
        }

        return $query->with('user')
            ->with('release')
            ->orderBy('created_at', 'desc')
            ->paginate(self::NEWS_FEED_PAGE_SIZE);
    }
}