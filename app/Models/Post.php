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

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    /**
     * @param $path
     * @param $extension
     * @param $mime_type
     * @param $size
     * @return PostImage
     */
    public function addImage($path, $extension, $mime_type, $size)
    {
        return PostImage::create([
            'post_id' => $this->id,
            'path' => $path,
            'extension' => $extension,
            'mime_type' => $mime_type,
            'size' => $size
        ]);
    }
}
