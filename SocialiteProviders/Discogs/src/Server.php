<?php

namespace SocialiteProviders\Discogs;

use League\OAuth1\Client\Credentials\TokenCredentials;
use SocialiteProviders\Manager\OAuth1\Server as BaseServer;
use SocialiteProviders\Manager\OAuth1\User;

class Server extends BaseServer
{
    /**
     * {@inheritDoc}
     */
    public function urlTemporaryCredentials()
    {
        return 'https://api.discogs.com/oauth/request_token';
    }

    /**
     * {@inheritDoc}
     */
    public function urlAuthorization()
    {
        return 'https://discogs.com/oauth/authorize';
    }

    /**
     * {@inheritDoc}
     */
    public function urlTokenCredentials()
    {
        return 'https://api.discogs.com/oauth/access_token';
    }

    /**
     * {@inheritDoc}
     */
    public function urlUserDetails()
    {
        return 'https://api.discogs.com/oauth/identity';
    }

    /**
     * {@inheritDoc}
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        $profile = $this->getUserProfile($data['username'], $tokenCredentials);

        $user           = new User();
        $user->id       = $profile['id'];
        $user->nickname = $profile['username'];
        $user->name     = $profile['name'];
        $user->email    = isset($profile['email']) ? $profile : null;
        $user->avatar   = $profile['avatar_url'];

        $used = ['id', 'username', 'name', 'email', 'avatar_url'];

        // extras
        $user->extra = array_diff_key($profile, $used);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        return $data['id'];
    }

    /**
     * {@inheritDoc}
     */
    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        $profile = $this->getUserProfile($data['username'], $tokenCredentials);
        return $profile['email'];
        //return '';
    }

    /**
     * {@inheritDoc}
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return $data['username'];
    }

    protected function getUserProfile($username, TokenCredentials $tokenCredentials)
    {
        // The identity endpoint only gives us the username and id. Need to then use the
        // username in an additional request to retrieve the rest of the user's details
        $profileUrl = "https://api.discogs.com/users/{$username}";
        $client = $this->createHttpClient();
        $headers = $this->getHeaders($tokenCredentials, 'GET', $profileUrl);
        $response = $client->get($profileUrl, $headers);
        return json_decode((string) $response->getBody(), true);
    }
}
