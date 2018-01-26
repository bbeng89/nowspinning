<?php

namespace App\Models;

use App\Events\UserCreated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property int $discogs_id
 * @property string $oauth_token
 * @property string $oauth_token_secret
 * @property string $username
 * @property string $name,
 * @property string $email
 * @property string $avatar
 * @property int|null $now_spinning_id
 * @property Shelf[] $shelves
 * @property UserRelease[] $releases
 * @property UserRelease $nowspinning
 * @property UserProfile $profile
 */
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
        'discogs_id', 'oauth_token', 'oauth_token_secret', 'username', 'name',
        'email', 'avatar', 'now_spinning_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'remember_token', 'oauth_token', 'oauth_token_secret'
    ];

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    public function releases()
    {
        return $this->hasMany(UserRelease::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function nowSpinning()
    {
        return $this->hasOne(UserRelease::class, 'id', 'now_spinning_id');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getShelf($handle)
    {
        return $this->shelves()->where('handle', $handle)->firstOrFail();
    }

    public function spin($release)
    {
        $this->now_spinning_id = $release->id;
        $this->save();

        $release->listen_count++;
        $release->save();

        return $this;
    }

    /**
     * @param string $content
     * @return Post
     */
    public function addPost($content, $showSpinning = true)
    {
        $post = Post::create([
            'user_id' => $this->id,
            'user_release_id' => $showSpinning ? $this->now_spinning_id : null,
            'content' => $content
        ]);
        $post->load('user', 'release');
        return $post;
    }
}
