<?php

namespace App\Http\Controllers\Api;

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

    public function index()
    {
        return $this->posts->getUserNewsFeed($this->user);
    }
}
