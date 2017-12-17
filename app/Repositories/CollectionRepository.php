<?php namespace App\Repositories;

use App\Models\User;
use App\Models\UserRelease;

class CollectionRepository
{
    public function findRelease($id)
    {
        return UserRelease::findOrFail($id);
    }

    public function getReleasesInShelf($username, $shelf_handle)
    {
        $user = User::where('username', $username)->firstOrFail();
        $shelf = $user->shelves()->where('handle', $shelf_handle)->firstOrFail();
        return $shelf->userReleases;
    }

    public function getShelfCounts($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $counts = [];
        foreach($user->shelves as $shelf)
        {
            $counts[$shelf->handle] = $shelf->userReleases()->count();
        }
        return $counts;
    }
}