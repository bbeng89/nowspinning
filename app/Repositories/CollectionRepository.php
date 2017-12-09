<?php namespace App\Repositories;

use App\Models\Release;

class CollectionRepository extends BaseDiscogsApiRepository
{
    const ALL_FOLDER = 0;
    const UNCATEGORIZED_FOLDER = 1;

    public function getAllReleasesInUserCollection($username = null)
    {
        return $this->getReleasesInFolder(self::ALL_FOLDER, $username);
    }

    public function getReleasesInUncategorizedFolder($username = null)
    {
        return $this->getReleasesInFolder(self::UNCATEGORIZED_FOLDER, $username);
    }

    public function getReleasesInFolder($folderId, $username = null)
    {
        $username = $username ?? $this->user->username;
        $resource = "/users/{$username}/collection/folders/{$folderId}/releases";

        return $this->get($resource, null, function($response) {
            return array_map(function($release){
                return Release::createFromApiResponse($release);
            }, $response->releases);
        });
    }
}