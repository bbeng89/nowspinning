<?php namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Cache\Repository as Cache;

abstract class BaseDiscogsApiRepository
{
    const BASE_URI = 'https://api.discogs.com/';

    const CACHE_MINUTES = 5;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
        $this->user = Auth::guard('api')->user();
    }

    protected function getHttpClient($auth = true)
    {
        $stack = HandlerStack::create();
        if($auth)
        {
            $middleware = new Oauth1([
                'consumer_key' => config('services.discogs.client_id'),
                'consumer_secret' => config('services.discogs.client_secret'),
                'token' => $this->user->oauth_token,
                'token_secret' => $this->user->oauth_token_secret
            ]);
            $stack->push($middleware);
        }

        return new Client([
            'base_uri' => self::BASE_URI,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }

    protected function get($url, $options, Callable $handler)
    {
        // This will first try to pull the result out of cache. It uses the $url as the key.
        // If it's not cached, or cache has expired, then it fetches from the discogs API and
        // feeds the response into the user-supplied $handler function, then caches the output
        // of that function.
        // todo - in the future I may change this to only cache the response from discogs, depending on what all the models need to do
        return $this->cache->remember($url, self::CACHE_MINUTES, function () use($url, $handler, $options)
        {
            $client = $this->getHttpClient();
            $resp = $client->get($url, $options);
            $response = json_decode($resp->getBody()->getContents());
            return $handler($response);
        });
    }
}