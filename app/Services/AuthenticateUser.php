<?php namespace App\Services;

use App\Models\User;
use App\Repositories\UserProfileRepository;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    protected $redirectTo = '/app';

    /**
     * @var Socialite
     */
    protected $socialite;

    /**
     * @var DiscogsApiHttpService
     */
    protected $http;

    public function __construct(Socialite $socialite, DiscogsApiHttpService $http)
    {
        $this->socialite = $socialite;
        $this->http = $http;
    }

    public function execute($hasToken)
    {
        if(!$hasToken) return $this->getAuthorization();

        $identity = $this->getDiscogsIdentity();

        $user = User::updateOrCreate(['discogs_id' => $identity->getId()], [
            'oauth_token' => $identity->token,
            'oauth_token_secret' => $identity->tokenSecret,
            'username' => $identity->getNickname()
        ]);

        Auth::login($user, true);

        // set the fields that have to be pulled from the user profile
        $client = $this->http->getClient($user->oauth_token, $user->oauth_token_secret);
        $resp = $client->get("/users/{$user->username}");
        $profile = json_decode($resp->getBody()->getContents());

        $user->name = $profile->name;
        $user->email = $profile->email;
        $user->avatar = $profile->avatar_url;
        $user->save();

        return redirect($this->redirectTo);
    }

    protected function getAuthorization()
    {
        return $this->socialite->driver('discogs')->redirect();
    }

    protected function getDiscogsIdentity()
    {
        return $this->socialite->driver('discogs')->user();
    }
}