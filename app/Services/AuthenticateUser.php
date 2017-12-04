<?php namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class AuthenticateUser
{
    protected $redirectTo = '/home';

    /**
     * @var Socialite
     */
    protected $socialite;

    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    public function execute($hasToken)
    {
        if(!$hasToken) return $this->getAuthorization();

        $identity = $this->getDiscogsIdentity();

        $profile = $this->getProfile([
            'consumer_key' => config('services.discogs.client_id'),
            'consumer_secret' => config('services.discogs.client_secret'),
            'token' => $identity->token,
            'token_secret' => $identity->tokenSecret
        ], $identity->getNickname());

        $user = User::firstOrCreate(['discogs_id' => $identity->getId()], [
            'oauth_token' => $identity->token,
            'oauth_token_secret' => $identity->tokenSecret,
            'username' => $identity->getNickname(),
            'name' => $profile->name,
            'email' => $profile->email,
            'avatar' => $identity->getAvatar()
        ]);

        Auth::login($user, true);

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

    protected function getProfile($keys, $username)
    {
        $stack = HandlerStack::create();
        $middleware = new Oauth1($keys);
        $stack->push($middleware);
        $client = new Client([
            'base_uri' => 'https://api.discogs.com/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);

        $resp = $client->get("/users/{$username}");
        return json_decode($resp->getBody()->getContents());
    }
}