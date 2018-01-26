<?php namespace App\Repositories;

use App\Models\User;

class PostRepository
{
    const NEWS_FEED_PAGE_SIZE = 50;

    public function getUserNewsFeed(User $user)
    {
        return $user->posts()
            ->with('user')
            ->with('release')
            ->orderBy('created_at', 'desc')
            ->paginate(self::NEWS_FEED_PAGE_SIZE);
    }
}