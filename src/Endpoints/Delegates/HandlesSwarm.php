<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Swarm;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesSwarm
{
    protected Swarm $swarm;

    public function getSwarm(): mixed
    {
        return $this->swarm->inspect();
    }

    public function initSwarm(): mixed
    {
        return $this->swarm->init();
    }

    public function joinSwarm(): mixed
    {
        return $this->swarm->join();
    }

    public function leaveSwarm(): mixed
    {
        return $this->swarm->leave();
    }

    public function updateSwarm(): mixed
    {
        return $this->swarm->update();
    }

    public function getKeyToUnlockSwarm(): mixed
    {
        return $this->swarm->keyToUnlock();
    }

    public function unlockSwarm(): mixed
    {
        return $this->swarm->unlock();
    }
}
