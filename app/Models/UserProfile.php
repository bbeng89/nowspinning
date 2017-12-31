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
        'speakers', 'preamp', 'other'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}