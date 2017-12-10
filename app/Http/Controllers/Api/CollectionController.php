<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CollectionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    protected $collection;

    public function __construct(CollectionRepository $collection)
    {
        $this->collection = $collection;
    }

    public function shelf($username, $shelf)
    {
        if(is_null($shelf)) return $this->collection->getAllReleasesInUserCollection($username);
        return $this->collection->getReleasesInShelf($shelf, $username);
    }

    public function shelfCounts($username)
    {
        return [
            'vinyl' => count($this->collection->getReleasesInShelf('vinyl', $username)),
            'cassette' => count($this->collection->getReleasesInShelf('cassette', $username)),
            'cd' => count($this->collection->getReleasesInShelf('cd', $username))
        ];
    }
}
