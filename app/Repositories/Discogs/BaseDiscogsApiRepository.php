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

    protected $oauth_token;

    protected $oauth_token_secret;

    public function __construct(DiscogsApiHttpService $http, Cache $cache)
    {
        $this->cache = $cache;
        $this->http = $http;
    }

    public function authorize($oauth_token, $oauth_token_secret)
    {
        $this->oauth_token = $oauth_token;
        $this->oauth_token_secret = $oauth_token_secret;
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return $this->http->getClient($this->oauth_token, $this->oauth_token_secret);
    }

    protected function get($url, $options = null)
    {
        $client = $this->getHttpClient();
        $resp = $client->get($url, $options);
        return json_decode($resp->getBody()->getContents());
    }
}