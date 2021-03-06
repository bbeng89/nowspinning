<?php namespace App\Repositories\Discogs;

use App\Models\Discogs\Release;
use App\Repositories\Discogs\BaseDiscogsApiRepository;

class CollectionRepository extends BaseDiscogsApiRepository
{
    const ALL_FOLDER = 0;
    const UNCATEGORIZED_FOLDER = 1;
    const CACHE_MINUTES = 2;

    public function getAllReleasesInUserCollection($username)
    {
        return $this->getReleasesInFolder(self::ALL_FOLDER, $username);
    }

    public function getReleasesInUncategorizedFolder($username)
    {
        return $this->getReleasesInFolder(self::UNCATEGORIZED_FOLDER, $username);
    }

    public function getReleasesInShelf($shelf, $username)
    {
        $cacheKey = "{$username}.collection.{$shelf}";

        return $this->cache->remember($cacheKey, self::CACHE_MINUTES, function () use($username, $shelf)
        {
            $formats = ['vinyl' => 'Vinyl', 'cassette' => 'Cassette', 'cd' => 'CD'];
            $format = $formats[$shelf];
            $all = $this->getAllReleasesInUserCollection($username);
            $filtered = array_filter($all, function($release) use($format){
                return in_array($format, $release->formats);
            });
            return array_values($filtered);
        });
    }

    public function getReleasesInFolder($folderId, $username)
    {
        $cacheKey = "{$username}.collection";
        $url = "/users/{$username}/collection/folders/{$folderId}/releases";

        return $this->cache->remember($cacheKey, self::CACHE_MINUTES, function () use($url)
        {
            $page = 1;
            $numPages = 1;
            $collection = [];

            while($page <= $numPages)
            {
                $queryString = ['per_page' => 100, 'page' => $page];
                $response = $this->get($url, ['query' => $queryString]);

                foreach($response->releases as $release)
                {
                    $collection[] = Release::createFromApiResponse($release);
                }

                $numPages = $response->pagination->pages;
                $page++;
            }
            usort($collection, function($a, $b){
                return $a->artistDisplay <=> $b->artistDisplay;
            });
            return $collection;
        });
    }
}