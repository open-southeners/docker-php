<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Swarm;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesSwarm
{
    protected Swarm $swarm;

    public function getSwarm()
    {
        return $this->swarm->inspect();
    }

    public function initSwarm()
    {
        return $this->swarm->init();
    }

    public function joinSwarm()
    {
        return $this->swarm->join();
    }

    public function leaveSwarm()
    {
        return $this->swarm->leave();
    }

    public function updateSwarm()
    {
        return $this->swarm->update();
    }

    public function getKeyToUnlockSwarm()
    {
        return $this->swarm->keyToUnlock();
    }

    public function unlockSwarm()
    {
        return $this->swarm->unlock();
    }
}
