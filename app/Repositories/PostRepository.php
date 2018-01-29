<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Post;

class PostRepository
{
    protected $feeds = ['global', 'friends'];

    protected $defaultPerPage = 50;

    public function getUserNewsFeed($feed, User $user, $perPage = null)
    {
        if(!in_array($feed, $this->feeds)) return [];

        if($feed == 'global')
        {
            $query = Post::query();
        }
        else if($feed == 'friends')
        {
            //todo - change this logic once friends are implemented
            $query = Post::where('user_id', $user->id);
        }

        return $query->with('user')
            ->with('release')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage ?? $this->defaultPerPage);
    }
}