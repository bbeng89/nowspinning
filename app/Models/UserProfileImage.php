<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App\Models
 * @property int $id
 * @property int $user_profile_id
 * @property string $path
 * @property string $extension
 * @property string $mime_type
 * @property int $size
 * @property UserProfile $userprofile
 */
class UserProfileImage extends Model
{
    protected $table = 'user_profile_images';

    protected $fillable = ['user_profile_id', 'path', 'extension', 'mime_type', 'size'];

    protected $hidden = ['path'];

    protected $appends = ['src'];

    public function post()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function getSrcAttribute()
    {
        return \Storage::url($this->path);
    }
}
