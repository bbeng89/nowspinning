<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\AddToShelfRequest;
use App\Http\Requests\User\RemoveFromShelfRequest;
use App\Http\Requests\User\SpinRequest;
use App\Models\User;
use App\Repositories\CollectionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    protected $collection;

    public function __construct(CollectionRepository $collection)
    {
        $this->user = Auth::guard('api')->user();
        $this->collection = $collection;
    }

    public function index(Request $request)
    {
        return User::with('nowSpinning')->findOrFail($this->user->id);
    }

    public function spin(SpinRequest $request)
    {
        $release = $this->collection->findRelease($request->id);
        $this->user->spin($release);
        return response("Success!", 200);
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
