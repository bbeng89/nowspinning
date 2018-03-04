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
            // todo - this probably wouldn't be a good way of achieving this if someone has thousands of friends
            $friendIds = $user->friends()->pluck('user_id');
            $friendIds[] = $user->id;
            $query->whereIn('user_id', $friendIds);
        }

        return $query->with('user')
            ->with('release')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage ?? $this->defaultPerPage);
    }
}