<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App\Models
 * @property $id
 * @property $user_id
 * @property $user_release_id
 * @property $content
 */
class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['user_id', 'user_release_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function release()
    {
        return $this->belongsTo(UserRelease::class, 'user_release_id');
    }
}
