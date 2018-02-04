<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App\Models
 * @property int $id
 * @property int $post_id
 * @property string $path
 * @property string $extension
 * @property string $mime_type
 * @property int $size
 */
class PostImage extends Model
{
    protected $table = 'post_images';

    protected $fillable = ['post_id', 'path', 'extension', 'mime_type', 'size'];

    protected $hidden = ['path'];

    protected $appends = ['src'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getSrcAttribute()
    {
        return \Storage::url($this->path);
    }
}
