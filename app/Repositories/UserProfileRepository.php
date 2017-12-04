<?php namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class UserProfileRepository extends BaseDiscogsApiRepository
{
    public function getProfile($username = null)
    {
        if(is_null($username))
        {
            $username = Auth::user()->username;
        }

        return $this->getAuthenticatedResource("/users/{$username}");
    }
}