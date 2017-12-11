<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserRelease;
use App\Repositories\Discogs\CollectionRepository;
use Illuminate\Console\Command;

class SyncDiscogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discogs:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user profiles and their collections from discogs';

    /**
     * @var CollectionRepository
     */
    protected $collection;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CollectionRepository $collection)
    {
        parent::__construct();
        $this->collection = $collection;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //todo - this all obviously needs to be refactored, but it gets the job done for now

        $users = User::all();

        foreach($users as $user)
        {
            $this->collection->authorize($user->oauth_token, $user->oauth_token_secret);

            $this->info("Retrieving {$user->username}'s collection from discogs API.");
            $apiObjs = $this->collection->getAllReleasesInUserCollection($user->username);

            $this->info("Creating eloquent objects");
            foreach($apiObjs as $release)
            {
                UserRelease::createOrUpdateFromApi($release, $user->id);
            }
            $this->info("Done");
        }
    }
}
