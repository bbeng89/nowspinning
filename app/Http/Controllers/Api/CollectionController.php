<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CollectionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    protected $collection;

    public function __construct(CollectionRepository $collection)
    {
        $this->collection = $collection;
    }

    public function shelf($username, $shelf)
    {
        return $this->collection->getReleasesInShelf($username, $shelf);
    }

    public function shelfCounts($username)
    {
        return $this->collection->getShelfCounts($username);
    }
}
