<?php namespace App\Models;

use App\Models\Discogs\Release;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRelease
 * @property int $id
 * @property int $user_id
 * @property int $discogs_id
 * @property int $discogs_folder_id
 * @property object $artists
 * @property string $title
 * @property int $release_year
 * @property Carbon $date_added date added to discogs
 * @property string $thumbnail
 * @property string $cover_image
 * @property string $discogs_url
 * @property int $listen_count
 * @package App\Models
 */
class UserRelease extends Model
{
    protected $table = 'user_releases';

    protected $fillable = ['user_id', 'discogs_id', 'discogs_folder_id', 'artists', 'title', 'release_year', 'date_added',
        'thumbnail', 'cover_image', 'discogs_url', 'listen_count'];

    protected $casts = ['artists' => 'array'];

    protected $appends = ['artists_display'];

    public function getArtistsDisplayAttribute()
    {
        return implode(', ', array_map(function($artist) {
            return $artist['name'];
        }, $this->artists));
    }

    public function shelves()
    {
        return $this->belongsToMany(Shelf::class, 'user_release_shelf');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createOrUpdateFromApi(Release $release, $user_id)
    {
        $userRelease = self::where('user_id', $user_id)
            ->where('discogs_id', $release->id)
            ->first();

        if(!$userRelease)
        {
            $userRelease = new UserRelease(['user_id' => $user_id]);
        }

        $userRelease->discogs_id = $release->id;
        $userRelease->discogs_folder_id = $release->folderId;
        $userRelease->artists = $release->artists;
        $userRelease->title = $release->title;
        $userRelease->release_year = $release->year;
        $userRelease->date_added = $release->dateAdded;
        $userRelease->thumbnail = $release->thumbnail;
        $userRelease->cover_image = $release->coverImage;
        $userRelease->discogs_url = $release->resourceUrl;
        $userRelease->save();

        $shelves = Shelf::whereIn('name', $release->formats)->pluck('id');

        if(!empty($shelves))
        {
            $userRelease->shelves()->syncWithoutDetaching($shelves);
        }

        return $userRelease;
    }
}
