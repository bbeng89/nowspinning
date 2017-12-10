<?php namespace App\Repositories;

use App\Services\DiscogsApiHttpService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Cache\Repository as Cache;

abstract class BaseDiscogsApiRepository
{
    const CACHE_MINUTES = 5;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var DiscogsApiHttpService
     */
    protected $http;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    public function __construct(DiscogsApiHttpService $http, Cache $cache)
    {
        $this->cache = $cache;
        $this->http = $http;
        $this->user = Auth::guard('api')->user();
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return $this->http->getClient($this->user->oauth_token, $this->user->oauth_token_secret);
    }

    protected function get($url, $options = null, Callable $handler = null)
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
            if(!is_null($handler))
            {
                return $handler($response);
            }
            return $response;
        });
    }
}