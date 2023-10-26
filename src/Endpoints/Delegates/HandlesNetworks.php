<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Networks;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesNetworks
{
    protected Networks $networks;

    public function getNetworks()
    {
        return $this->networks->list();
    }

    public function getNetwork(string $id)
    {
        return $this->networks->inspect($id);
    }

    public function removeNetwork(string $id)
    {
        return $this->networks->remove($id);
    }

    public function create(string $id)
    {
        return $this->networks->create($id);
    }

    public function attachNetworkToContainer(string $id)
    {
        return $this->networks->attachToContainer($id);
    }

    public function removeNetworkFromContainer(string $id)
    {
        return $this->networks->removeFromContainer($id);
    }

    public function pruneUnusedNetworks()
    {
        return $this->networks->prune();
    }
}
