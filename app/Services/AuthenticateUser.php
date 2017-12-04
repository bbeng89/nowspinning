<?php namespace App\Services;

use App\Models\User;
use App\Repositories\UserProfileRepository;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    protected $redirectTo = '/home';

    /**
     * @var Socialite
     */
    protected $socialite;

    /**
     * @var UserProfileRepositoryBase
     */
    protected $users;

    public function __construct(Socialite $socialite, UserProfileRepository $users)
    {
        $this->socialite = $socialite;
        $this->users = $users;
    }

    public function execute($hasToken)
    {
        if(!$hasToken) return $this->getAuthorization();

        $identity = $this->getDiscogsIdentity();

        $user = User::updateOrCreate(['discogs_id' => $identity->getId()], [
            'oauth_token' => $identity->token,
            'oauth_token_secret' => $identity->tokenSecret,
            'username' => $identity->getNickname(),
            'avatar' => $identity->getAvatar()
        ]);

        Auth::login($user, true);

        // set the fields that have to be pulled from the user profile
        $profile = $this->users->getProfile($identity->getNickname());
        $user->name = $profile->name;
        $user->email = $profile->email;
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