<?php

namespace Tests\Feature\Api;

use App\Jobs\SyncUserDiscogsCollection;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserRelease;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function testRetrievingCurrentUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->get('/api/user')
            ->assertJson([
                'id' => $user->id,
                'discogs_id' => $user->discogs_id,
                'now_spinning' => null
            ]);
    }

    public function testRetrievingUserProfile()
    {
        $user = factory(User::class)->create();
        $profile = factory(UserProfile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api')
            ->get("/api/user/profile/{$user->id}")
            ->assertJson($profile->toArray());
    }

    public function testUpdatingUserProfile()
    {
        $user = factory(User::class)->create();
        $profile = factory(UserProfile::class)->create(['user_id' => $user->id]);
        $newValues = [
            'turntable' => 'Pro-Ject Debut Carbon',
            'tape_deck' => 'Nakamichi Dragon'
        ];

        $this->actingAs($user, 'api')
            ->post("/api/user/profile/update", $newValues)
            ->assertSuccessful();

        $this->assertEquals($newValues['turntable'], $user->profile->turntable);
        $this->assertEquals($newValues['tape_deck'], $user->profile->tape_deck);
        // any values not passed should be cleared
        $this->assertNull($user->profile->cd_player);
    }

    public function testSpin()
    {
        $user = factory(User::class)->create();
        $release = factory(UserRelease::class)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api')
            ->post('/api/user/spin', ['id' => $release->id])
            ->assertSuccessful();

        $this->assertEquals($release->id, $user->now_spinning_id);
    }

    public function testSync()
    {
        $user = factory(User::class)->create();
        Bus::fake();

        $this->actingAs($user, 'api')
            ->post('/api/user/sync')
            ->assertSuccessful();

        Bus::assertDispatched(SyncUserDiscogsCollection::class, function($job) use($user){
            return $job->user->id == $user->id;
        });
    }
}
