<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\SpinRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    public function index(Request $request)
    {
        return $this->user;
    }

    public function spin(SpinRequest $request)
    {
        $this->user->spin($request->id);
        return response("Success!", 200);
    }
}
