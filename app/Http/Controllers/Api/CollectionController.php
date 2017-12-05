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

    public function all(Request $request)
    {
        $collection = $this->collection->getAllItemsInUserCollection($request->user->username);
        return response()->json($collection);
    }
}
