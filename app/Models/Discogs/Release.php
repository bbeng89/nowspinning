<?php

namespace App\Models\Discogs;

use App\Models\Discogs\Artist;
use Carbon\Carbon;

class Release
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $folderId;
    /**
     * @var Artist[]
     */
    public $artists;
    /**
     * @var string
     */
    public $artistDisplay;
    /**
     * @var string
     */
    public $title;
    /**
     * @var array
     */
    public $formats;
    /**
     * @var int
     */
    public $year;
    /**
     * @var Carbon
     */
    public $dateAdded;
    /**
     * @var string
     */
    public $thumbnail;
    /**
     * @var string
     */
    public $coverImage;
    /**
     * @var string
     */
    public $resourceUrl;

    public static function createFromApiResponse($obj)
    {
        $release = new Release();
        $release->id = $obj->id;
        $release->folderId = $obj->folder_id;
        $release->title = $obj->basic_information->title;
        $release->year = $obj->basic_information->year;
        $release->thumbnail = $obj->basic_information->thumb;
        $release->coverImage = $obj->basic_information->cover_image;
        $release->resourceUrl = $obj->basic_information->resource_url;
        $release->dateAdded = Carbon::createFromFormat(\DateTime::ISO8601, $obj->date_added);

        $release->artists = array_map(function($artistObj) {
            return Artist::createFromApiResponse($artistObj);
        }, $obj->basic_information->artists);

        $release->formats = array_map(function($formatObj) {
            return $formatObj->name;
        }, $obj->basic_information->formats);

        $release->artistDisplay = implode(", ", array_map(function($artist) {
            return $artist->name;
        }, $release->artists));

        return $release;
    }

}