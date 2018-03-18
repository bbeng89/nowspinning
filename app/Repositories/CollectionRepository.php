<?php namespace App\Repositories;

use App\Models\Shelf;
use App\Models\User;
use App\Models\UserRelease;

class CollectionRepository
{
    const DEFAULT_PAGE_SIZE = 50;

    public function findRelease($id)
    {
        return UserRelease::with('shelves')->findOrFail($id);
    }

    public function getReleasesInShelf($username, $shelf_handle, $search = null, $sort = null, $pageSize = null)
    {
        $user = User::where('username', $username)->firstOrFail();

        if($shelf_handle == 'all')
        {
            $releases = $user->releases()->with('shelves');
        }
        else
        {
            $shelf = $user->shelves()->where('handle', $shelf_handle)->firstOrFail();
            $releases = $shelf->userReleases()->with('shelves');
        }

        if(!empty($search))
        {
            $releases->where(function($query) use($search) {
                $query->where('artists_display', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%");
            });
        }

        if(!empty($sort))
        {
            list($field, $dir) = explode(",", $sort);
            $releases->orderBy($field, $dir);
        }

        return $releases->paginate($pageSize ?? self::DEFAULT_PAGE_SIZE);
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