<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\UserRelease;
use App\Repositories\Discogs\CollectionRepository;

class SyncUserDiscogsCollection
{
    use Dispatchable;

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CollectionRepository $collection)
    {
        $collection->authorize($this->user->oauth_token, $this->user->oauth_token_secret);

        $apiObjs = $collection->getAllReleasesInUserCollection($this->user->username);

        foreach($apiObjs as $release)
        {
            UserRelease::createOrUpdateFromApi($release, $this->user->id);
        }
    }
}
