<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class UserDiscogsCollectionSynced
{
    use Dispatchable;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $beforeCount;

    /**
     * @var int
     */
    protected $afterCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $beforeCount, $afterCount)
    {
        $this->user = $user;
        $this->beforeCount = $beforeCount;
        $this->afterCount = $afterCount;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getBeforeCount()
    {
        return $this->beforeCount;
    }

    /**
     * @return int
     */
    public function getAfterCount()
    {
        return $this->afterCount;
    }

    /**
     * @return bool
     */
    public function newReleasesAdded()
    {
        return $this->afterCount > $this->beforeCount;
    }

    /**
     * @return int
     */
    public function getNumberOfReleasesAdded()
    {
        return $this->afterCount - $this->beforeCount;
    }

    /**
     * @return bool
     */
    public function releasesRemoved()
    {
        return $this->afterCount < $this->beforeCount;
    }

    /**
     * @return int
     */
    public function getNumberOfReleasesRemoved()
    {
        return $this->beforeCount - $this->afterCount;
    }
}
