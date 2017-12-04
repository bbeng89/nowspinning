<?php namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Support\Facades\Auth;

abstract class BaseDiscogsApiRepository
{
    protected $baseUri = 'https://api.discogs.com/';

    protected function getAuthenticatedHttpClient()
    {
        $user = Auth::user();
        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key' => config('services.discogs.client_id'),
            'consumer_secret' => config('services.discogs.client_secret'),
            'token' => $user->oauth_token,
            'token_secret' => $user->oauth_token_secret
        ]);
        $stack->push($middleware);
        $client = new Client([
            'base_uri' => $this->baseUri,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);

        return $client;
    }

    protected function getAuthenticatedResource($url, $options = null)
    {
        $client = $this->getAuthenticatedHttpClient();
        $resp = $client->get($url, $options);
        return json_decode($resp->getBody()->getContents());
    }
}