<?php namespace App\Repositories\Discogs;

use App\Repositories\Discogs\BaseDiscogsApiRepository;
use Illuminate\Support\Facades\Auth;

class UserProfileRepository extends BaseDiscogsApiRepository
{
    const CACHE_MINUTES = 5;

    public function getProfile($username = null)
    {
        $username = $username ?? $this->user->username;
        // if the authenticated user is getting their own profile, extra fields are returned so it needs to be cached separately
        $cacheKey = $username == $this->user->username
            ? "{$username}.self"
            : "{$username}.profile";

        return $this->cache->remember($cacheKey, self::CACHE_MINUTES, function () use($username)
        {
            return $this->get("/users/{$username}");
        });
    }
}