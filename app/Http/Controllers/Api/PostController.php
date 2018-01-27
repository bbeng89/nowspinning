<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Post\CreatePostRequest;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var PostRepository
     */
    protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->user = Auth::guard('api')->user();
        $this->posts = $posts;
    }

    public function index($feed)
    {
        return $this->posts->getUserNewsFeed($feed, $this->user);
    }

    public function create(CreatePostRequest $request)
    {
        $showSpinning = $request->has('showSpinning') && $request->get('showSpinning') == 'true';
        return $this->user->addPost($request->get('content'), $showSpinning);
    }
}
