<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Models\UserRelease;
use App\Repositories\CollectionRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFindingReleases()
    {
        $release = factory(UserRelease::class)->create();
        $repo = $this->app->make(CollectionRepository::class);

        $foundRelease = $repo->findRelease($release->id);

        $this->assertEquals($release->discogs_id, $foundRelease->discogs_id);
    }

    public function testGettingAllReleasesInShelf()
    {
        $releaseCount = 5;
        $user = factory(User::class)->create();
        $releases = factory(UserRelease::class, $releaseCount)->create(['user_id' => $user->id]);
        $user->shelves()->where('handle', 'vinyl')->firstOrFail()->userReleases()->attach($releases->pluck('id'));

        $repo = $this->app->make(CollectionRepository::class);
        $result = $repo->getReleasesInShelf($user->username, 'vinyl');
        $this->assertCount($releaseCount, $result);
    }

    public function testSearchingShelf()
    {
        $releaseCount = 5;
        $shelf = 'vinyl';
        $title = 'A Blaze in the Northern Sky';
        $artists_display = 'Darkthrone';

        $repo = $this->app->make(CollectionRepository::class);
        $user = factory(User::class)->create();
        $releases = factory(UserRelease::class, $releaseCount)->create(['user_id' => $user->id]);
        $specific = factory(UserRelease::class)->create([
            'user_id' => $user->id,
            'title' => $title,
            'artists_display' => $artists_display
        ]);

        $user->shelves()->where('handle', $shelf)
            ->firstOrFail()
            ->userReleases()
            ->attach($releases->pluck('id')->push($specific->id));

        $result = $repo->getReleasesInShelf($user->username, $shelf, $title);
        $this->assertCount(1, $result);
        $this->assertEquals($specific->id, $result[0]->id);

        $result = $repo->getReleasesInShelf($user->username, $shelf, $artists_display);
        $this->assertCount(1, $result);
        $this->assertEquals($specific->id, $result[0]->id);
    }

    public function testGettingSortedReleasesInShelf()
    {
        $releaseTitles = ['a', 'b', 'c'];
        $shelfHandle = 'vinyl';
        $repo = $this->app->make(CollectionRepository::class);
        $user = factory(User::class)->create();
        $shelf = $user->shelves()->where('handle', $shelfHandle)->firstOrFail();

        foreach($releaseTitles as $title)
        {
            $release = factory(UserRelease::class)->create(['user_id' => $user->id, 'title' => $title]);
            $shelf->userReleases()->attach($release->id);
        }

        $ascendingResults = $repo->getReleasesInShelf($user->username, $shelfHandle, null, 'title,asc');
        $descendingResults = $repo->getReleasesInShelf($user->username, $shelfHandle, null, 'title,desc');

        $this->assertEquals($ascendingResults[0]->title, $releaseTitles[0]);
        $this->assertEquals($descendingResults[0]->title, end($releaseTitles));
    }

    public function testGettingShelfCounts()
    {
        $shelves = ['vinyl' => 5, 'cassette' => 2];
        $repo = $this->app->make(CollectionRepository::class);
        $user = factory(User::class)->create();

        foreach($shelves as $handle => $count)
        {
            $releases = factory(UserRelease::class, $count)->create(['user_id' => $user->id]);
            $user->shelves()->where('handle', $handle)
                ->firstOrFail()
                ->userReleases()
                ->attach($releases->pluck('id'));
        }

        $results = $repo->getShelfCounts($user->username);
        $this->assertCount(count(config('constants.default_shelves')), $results);

        foreach($results as $handle => $count)
        {
            if(isset($shelves[$handle]))
            {
                $this->assertEquals($shelves[$handle], $count);
            }
        }
    }
}
