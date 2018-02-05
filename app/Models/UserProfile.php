<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserProfile
 * @package App\Models
 * @property int $user_id
 * @property string $turntable
 * @property string $turntable_cartridge
 * @property string $cd_player
 * @property string $tape_deck
 * @property string $amp_receiver
 * @property string $speakers
 * @property string $preamp
 * @property string $other
 */
class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'turntable', 'turntable_cartridge', 'cd_player', 'tape_deck', 'amp_receiver',
        'speakers', 'preamp', 'subwoofer', 'other'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(UserProfileImage::class);
    }

    /**
     * @param $path
     * @param $extension
     * @param $mime_type
     * @param $size
     * @return UserProfileImage
     */
    public function addImage($path, $extension, $mime_type, $size)
    {
        return UserProfileImage::create([
            'user_profile_id' => $this->id,
            'path' => $path,
            'extension' => $extension,
            'mime_type' => $mime_type,
            'size' => $size
        ]);
    }
}