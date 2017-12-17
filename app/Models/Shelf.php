<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shelf
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $handle
 */
class Shelf extends Model
{
    protected $table = 'shelves';

    protected $fillable = ['user_id', 'name', 'handle'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userReleases()
    {
        return $this->belongsToMany(UserRelease::class, 'user_release_shelf');
    }

    public function addRelease(UserRelease $release)
    {
        $this->userReleases()->attach($release->id);
    }
}