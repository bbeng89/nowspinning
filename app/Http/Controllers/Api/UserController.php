<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\DeleteProfileImageRequest;
use App\Http\Requests\User\FollowRequest;
use App\Http\Requests\User\SpinRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UploadProfileImageRequest;
use App\Jobs\SyncUserDiscogsCollection;
use App\Models\User;
use App\Models\UserProfileImage;
use App\Repositories\CollectionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var CollectionRepository
     */
    protected $collection;

    /**
     * @var UserRepository
     */
    protected $users;

    public function __construct(CollectionRepository $collection, UserRepository $users)
    {
        $this->user = Auth::guard('api')->user();
        $this->collection = $collection;
        $this->users = $users;
    }

    public function index(Request $request)
    {
        return $this->users->find($this->user->id);
    }

    public function find($username)
    {
        return $this->users->getByUsername($username);
    }

    public function sync()
    {
        SyncUserDiscogsCollection::dispatch($this->user);
        return response("Success!", 200);
    }

    public function spin(SpinRequest $request)
    {
        $release = $this->collection->findRelease($request->id);
        return $this->user->spin($release);
    }

    public function follow(FollowRequest $request)
    {
        $newFriend = $this->users->getByUsername($request->username);
        $this->user->follow($newFriend);
        return response("Success!", 200);
    }

    public function unfollow(FollowRequest $request)
    {
        $oldFriend = $this->users->getByUsername($request->username);
        $this->user->unfollow($oldFriend);
        return response("Success :(", 200);
    }

    public function getProfile($userid)
    {
        return $this->users->getProfile($userid);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->users->updateProfile($this->user->id, $request->all());
        return response('Success!', 200);
    }

    public function uploadProfileImage(UploadProfileImageRequest $request)
    {
        $profile = $this->user->profile;
        $file = $request->file('file');
        $path = $file->store('public/profileimgs');
        return $profile->addImage($path, $file->extension(), $file->getMimeType(), $file->getSize());
    }

    public function deleteProfileImage(DeleteProfileImageRequest $request)
    {
        UserProfileImage::destroy($request->id);
        return response('Success!', 200);
    }

    public function unsetFirstLogin()
    {
        $this->user->first_login = false;
        $this->user->save();
        return response('Success!', 200);
    }

    public function search(Request $request)
    {
        if(!$request->has('query'))
        {
            abort(404, "Query not provided");
        }

        return $this->users->search($request->get('query'));
    }

    public function friends($username)
    {
        $user = $this->users->getByUsername($username);
        return $user->friends()->with('nowSpinning')->get();
    }
}
