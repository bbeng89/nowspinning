<?php

namespace App\Models;

use App\Events\UserCreated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $dispatchesEvents = [
        'created' => UserCreated::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discogs_id', 'oauth_token', 'oauth_token_secret', 'username', 'name', 'email', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'remember_token',
    ];

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    public function releases()
    {
        return $this->hasMany(UserRelease::class);
    }

    public function nowSpinning()
    {
        return $this->hasOne(UserRelease::class, 'id', 'now_spinning_id');
    }

    public function getShelf($handle)
    {
        return $this->shelves()->where('handle', $handle)->firstOrFail();
    }

    public function spin($userReleaseId)
    {
        $this->now_spinning_id = $userReleaseId;
        $this->save();
        return $this;
    }
}
