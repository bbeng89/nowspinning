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
        // need to make a request to https://api.discogs.com/users/{username} to retrieve name, email, and avatar
        $user           = new User();
        $user->id       = $data['id'];
        $user->nickname = $data['username'];
        $user->name     = null;
        $user->email    = null;
        $user->avatar   = null;

        $used = ['id', 'username'];

        foreach ($data as $key => $value) {
            if (!in_array($key, $used)) {
                $used[] = $key;
            }
        }

        $user->extra = array_diff_key($data, array_flip($used));
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
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        return $data['username'];
    }
}
