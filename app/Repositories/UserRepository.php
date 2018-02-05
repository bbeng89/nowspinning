<?php namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;

class UserRepository
{
    /**
     * @param int $id
     * @return User
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param string $username
     * @return User
     */
    public function getByUsername($username)
    {
        return User::where('username', $username)->firstOrFail();
    }

    /**
     * @param int $userid
     * @return UserProfile
     */
    public function getProfile($userid)
    {
        $user = $this->find($userid);
        $profile = $user->profile;
        $profile->loadMissing('images');
        return $profile;
    }

    /**
     * @param $userId
     * @param $args
     * @return UserProfile
     */
    public function updateProfile($userId, $args)
    {
        $user = $this->find($userId);
        $profile = UserProfile::updateOrCreate(['user_id' => $user->id], [
            'turntable' => $args['turntable'] ?? null,
            'turntable_cartridge' => $args['turntable_cartridge'] ?? null,
            'cd_player' => $args['cd_player'] ?? null,
            'tape_deck' => $args['tape_deck'] ?? null,
            'amp_receiver' => $args['amp_receiver'] ?? null,
            'preamp' => $args['preamp'] ?? null,
            'speakers' => $args['speakers'] ?? null,
            'subwoofer' => $args['subwoofer'] ?? null,
            'other' => $args['other'] ?? null
        ]);
        return $profile;
    }
}