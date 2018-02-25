<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\AddToShelfRequest;
use App\Http\Requests\User\RemoveFromShelfRequest;
use App\Models\User;
use App\Models\UserRelease;
use App\Repositories\CollectionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * @var CollectionRepository
     */
    protected $collection;

    /**
     * @var User
     */
    protected $user;

    public function __construct(CollectionRepository $collection)
    {
        $this->user = Auth::guard('api')->user();
        $this->collection = $collection;
    }

    public function shelf(Request $request, $username, $shelf)
    {
        $search = $request->get('search', null);
        $sort = $request->get('sort', null);
        $pageSize = $request->get('page_size', null);
        return $this->collection->getReleasesInShelf($username, $shelf, $search, $sort, $pageSize);
    }

    public function release($id)
    {
        return UserRelease::findOrFail($id);
    }

    public function shelfCounts($username)
    {
        return $this->collection->getShelfCounts($username);
    }

    public function addToShelf(AddToShelfRequest $request)
    {
        $release = $this->collection->findRelease($request->releaseId);
        $shelf = $this->user->getShelf($request->shelfHandle);
        $shelf->addRelease($release);
        return response('Success!', 200);
    }

    public function removeFromShelf(RemoveFromShelfRequest $request)
    {
        $release = $this->collection->findRelease($request->releaseId);
        $shelf = $this->user->getShelf($request->shelfHandle);
        $shelf->removeRelease($release);
        return response('Success!', 200);
    }
}
