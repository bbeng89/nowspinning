<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthenticateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @var AuthenticateUser
     */
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthenticateUser $auth)
    {
        $this->middleware('guest')->except('logout');

        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        return $this->auth->execute($request->has('oauth_token'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
