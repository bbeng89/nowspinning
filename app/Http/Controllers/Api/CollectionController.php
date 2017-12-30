<?php

namespace App\Http\Controllers\Api;

use App\Models\UserRelease;
use App\Repositories\CollectionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    protected $collection;

    public function __construct(CollectionRepository $collection)
    {
        $this->collection = $collection;
    }

    public function shelf(Request $request, $username, $shelf)
    {
        $search = $request->get('search', null);
        $sort = $request->get('sort', null);
        return $this->collection->getReleasesInShelf($username, $shelf, $search, $sort);
    }

    public function shelfCounts($username)
    {
        return $this->collection->getShelfCounts($username);
    }

    public function release($id)
    {
        return UserRelease::findOrFail($id);
    }
}
