<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UploadPostImageRequest;
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

    public function index(Request $request, $feed)
    {
        return $this->posts->getUserNewsFeed($feed, $this->user, $request->get('per_page'));
    }

    public function create(CreatePostRequest $request)
    {
        $showSpinning = $request->has('showSpinning') && $request->get('showSpinning') == 'true';
        return $this->user->addPost($request->get('content'), $showSpinning);
    }

    public function uploadPostImage(UploadPostImageRequest $request)
    {
        $post = $this->posts->find($request->post_id);
        $file = $request->file('file');
        $path = $file->store('public/postimgs');
        return $post->addImage($path, $file->extension(), $file->getMimeType(), $file->getSize());
    }

    public function delete($id)
    {
        $post = $this->posts->find($id);
        $post->delete();
        return response("Success!", 200);
    }
}
