<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRelease
 * @property int $id
 * @property int $discogs_id
 * @property int $discogs_folder_id
 * @property object $artists
 * @property string $title
 * @property int $release_year
 * @property Carbon $date_added date added to discogs
 * @property string $thumbnail
 * @property string $cover_image
 * @property string $discogs_url
 * @package App\Models
 */
class UserRelease extends Model
{
    protected $table = 'user_releases';

    protected $fillable = ['discogs_id', 'discogs_folder_id', 'artists', 'title', 'release_year', 'date_added',
        'thumbnail', 'cover_image', 'discogs_url'];

    public function shelves()
    {
        return $this->belongsToMany(Shelf::class, 'user_release_shelf');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
