<?php namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class CollectionRepository extends BaseDiscogsApiRepository
{
    const ALL_FOLDER = 0;
    const UNCATEGORIZED_FOLDER = 1;

    public function getAllItemsInUserCollection($username = null)
    {
        return $this->getItemsInFolder($username, self::ALL_FOLDER);
    }

    public function getItemsInUncategorizedFolder($username = null)
    {
        return $this->getItemsInFolder($username, self::UNCATEGORIZED_FOLDER);
    }

    public function getItemsInFolder($username, $folderId)
    {
        if(is_null($username))
        {
            $username = Auth::user()->username;
        }

        return $this->getAuthenticatedResource("/users/{$username}/collection/folders/{$folderId}/releases");
    }
}