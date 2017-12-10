<?php namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class UserProfileRepository extends BaseDiscogsApiRepository
{
    public function getProfile($username = null)
    {
        $username = $username ?? $this->user->username;
        return $this->get("/users/{$username}");
    }
}