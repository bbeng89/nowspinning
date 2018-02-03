<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Models\UserProfile;
use App\Repositories\UserRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFindingUsers()
    {
        $user = factory(User::class)->create();
        $repo = $this->app->make(UserRepository::class);
        $this->assertEquals($user->username, $repo->find($user->id)->username);
        $this->assertEquals($user->id, $repo->getByUsername($user->username)->id);
    }

    public function testRetrievingUserProfile()
    {
        $user = factory(User::class)->create();
        $profile = factory(UserProfile::class)->create(['user_id' => $user->id]);
        $repo = $this->app->make(UserRepository::class);

        $retrievedProfile = $repo->getProfile($user->id);
        $this->assertEquals($profile->id, $retrievedProfile->id);
    }

    public function testUpdatingProfile()
    {
        $user = factory(User::class)->create();
        $profile = factory(UserProfile::class)->create(['user_id' => $user->id]);
        $repo = $this->app->make(UserRepository::class);
        $newValues = [
            'turntable' => 'Pro-Ject Debut Carbon',
            'tape_deck' => 'Nakamichi Dragon'
        ];

        $repo->updateProfile($user->id, $newValues);

        $this->assertEquals($newValues['turntable'], $user->profile->turntable);
        $this->assertEquals($newValues['tape_deck'], $user->profile->tape_deck);
        // values not specified should be cleared
        $this->assertNull($user->profile->cd_player);
    }
}
