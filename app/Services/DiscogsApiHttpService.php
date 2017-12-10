<?php namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class DiscogsApiHttpService
{
    const BASE_URI = 'https://api.discogs.com/';

    /**
     * @param null $oauth_token
     * @param null $oauth_secret
     * @return Client
     */
    public function getClient($oauth_token = null, $oauth_secret = null)
    {
        $stack = HandlerStack::create();

        if(!is_null($oauth_token) && !is_null($oauth_secret))
        {
            $middleware = new Oauth1([
                'consumer_key' => config('services.discogs.client_id'),
                'consumer_secret' => config('services.discogs.client_secret'),
                'token' => $oauth_token,
                'token_secret' => $oauth_secret
            ]);
            $stack->push($middleware);
        }

        return new Client([
            'base_uri' => self::BASE_URI,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }
}