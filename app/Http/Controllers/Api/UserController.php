<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\SpinRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Jobs\SyncUserDiscogsCollection;
use App\Models\User;
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
        return User::with('nowSpinning')->findOrFail($this->user->id);
    }

    public function sync()
    {
        SyncUserDiscogsCollection::dispatch($this->user);
        return response("Success!", 200);
    }

    public function spin(SpinRequest $request)
    {
        $release = $this->collection->findRelease($request->id);
        $this->user->spin($release);
        return response("Success!", 200);
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

    public function unsetFirstLogin()
    {
        $this->user->first_login = false;
        $this->user->save();
        return response('Success!', 200);
    }
}
