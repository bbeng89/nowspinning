<?php namespace App\Repositories\Discogs;

use App\Services\DiscogsApiHttpService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Cache\Repository as Cache;

abstract class BaseDiscogsApiRepository
{
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

    protected function get($url, $options = null)
    {
        $client = $this->getHttpClient();
        $resp = $client->get($url, $options);
        return json_decode($resp->getBody()->getContents());
    }
}