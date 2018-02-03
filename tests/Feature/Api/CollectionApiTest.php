<?php

namespace Tests\Feature\Api;

use App\Models\Shelf;
use App\Models\User;
use App\Models\UserRelease;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionApiTest extends TestCase
{
    use RefreshDatabase;

    protected $vinylCount = 10;

    protected $cassetteCount = 2;

    public function testGettingReleasesFromShelf()
    {
        $this->setUpDatabase();
        $user = User::first();
        $this->actingAs($user, 'api')
            ->get("/api/collection/{$user->username}/vinyl")
            ->assertJsonCount($this->vinylCount, 'data');
    }

    public function testRetrievingRelease()
    {
        $this->setUpDatabase();
        $user = User::first();
        $release = $user->releases()->first();

        $this->actingAs($user, 'api')
            ->get("/api/collection/release/{$release->id}")
            ->assertJson(['id' => $release->id])
            ->assertJson(['user_id' => $user->id]);
    }

    public function testRetrievingShelfCounts()
    {
        $this->setUpDatabase();
        $user = User::first();
        $defaultShelves = config('constants.default_shelves');

        $this->actingAs($user, 'api')
            ->get("/api/collection/{$user->username}/shelves/counts")
            ->assertJsonCount(count($defaultShelves))
            ->assertJson([
                'vinyl' => $this->vinylCount,
                'cassette' => $this->cassetteCount,
                'cd' => 0,
                'heavy-rotation' => 0,
                'on-deck' => 0
            ]);
    }

    public function testAddingToShelf()
    {
        $this->setUpDatabase();
        $user = User::first();
        $release = $user->releases()->first();
        $shelfHandle = 'on-deck';
        $shelf = $user->shelves()->where('handle', $shelfHandle)->firstOrFail();

        $this->actingAs($user, 'api')
            ->post('/api/collection/shelf/add-release', [
                'releaseId' => $release->id,
                'shelfHandle' => $shelfHandle
            ])->assertSuccessful();

        $this->assertCount(1, $shelf->userReleases);
    }

    public function testRemovingFromShelf()
    {
        $this->setUpDatabase();
        $user = User::first();
        $release = $user->releases()->first();
        $shelfHandle = 'vinyl';
        $shelf = $user->shelves()->where('handle', $shelfHandle)->firstOrFail();

        $this->actingAs($user, 'api')
            ->post('/api/collection/shelf/remove-release', [
                'releaseId' => $release->id,
                'shelfHandle' => $shelfHandle
            ])->assertSuccessful();

        $this->assertCount($this->vinylCount - 1, $shelf->userReleases);
    }

    public function setUpDatabase()
    {
        $user1 = factory(User::class)->create();
        $user1vinylShelf = $user1->shelves()->where('handle', 'vinyl')->firstOrFail();
        $user1vinyl = factory(UserRelease::class, $this->vinylCount)->create(['user_id' => $user1->id]);
        $user1vinylShelf->userReleases()->attach($user1vinyl->pluck('id'));

        $user1cassetteShelf = $user1->shelves()->where('handle', 'cassette')->firstOrFail();
        $user1cassettes = factory(UserRelease::class, $this->cassetteCount)->create(['user_id' => $user1->id]);
        $user1cassetteShelf->userReleases()->attach($user1cassettes->pluck('id'));

        $user2 = factory(User::class)->create();
        $user2vinylShelf = $user2->shelves()->where('handle', 'vinyl')->firstOrFail();
        $user2releases = factory(UserRelease::class, $this->vinylCount)->create(['user_id' => $user2->id]);
        $user2vinylShelf->userReleases()->attach($user2releases->pluck('id'));

        $user2cassetteShelf = $user2->shelves()->where('handle', 'cassette')->firstOrFail();
        $user2cassettes = factory(UserRelease::class, $this->cassetteCount)->create(['user_id' => $user2->id]);
        $user2cassetteShelf->userReleases()->attach($user2cassettes->pluck('id'));
    }
}
