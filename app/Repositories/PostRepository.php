<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Post;

class PostRepository
{
    protected $feeds = ['global', 'friends'];

    protected $defaultPerPage = 25;

    /**
     * @param $id
     * @return Post
     */
    public function find($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * @param $feed
     * @param User $user
     * @param null $perPage
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserNewsFeed($feed, User $user, $perPage = null)
    {
        if(!in_array($feed, $this->feeds)) return [];
        $query = Post::with('images');

        if($feed == 'friends')
        {
            //todo - change this logic once friends are implemented
            $query->where('user_id', $user->id);
        }

        return $query->with('user')
            ->with('release')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage ?? $this->defaultPerPage);
    }
}