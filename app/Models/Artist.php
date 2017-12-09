<?php

namespace App\Models;

class Artist
{
    public $id;
    public $name;
    public $resourceUrl;

    public static function createFromApiResponse($obj)
    {
        $artist = new Artist();
        $artist->id = $obj->id;
        $artist->name = $obj->name;
        $artist->resourceUrl = $obj->resource_url;
        return $artist;
    }
}