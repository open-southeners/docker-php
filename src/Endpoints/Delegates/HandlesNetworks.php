<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Networks;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesNetworks
{
    protected Networks $networks;

    public function getNetworks(): mixed
    {
        return $this->networks->list();
    }

    public function getNetwork(string $id): mixed
    {
        return $this->networks->inspect($id);
    }

    public function removeNetwork(string $id): mixed
    {
        return $this->networks->remove($id);
    }

    public function create(string $id): mixed
    {
        return $this->networks->create($id);
    }

    public function attachNetworkToContainer(string $id): mixed
    {
        return $this->networks->attachToContainer($id);
    }

    public function removeNetworkFromContainer(string $id): mixed
    {
        return $this->networks->removeFromContainer($id);
    }

    public function pruneUnusedNetworks(): mixed
    {
        return $this->networks->prune();
    }
}
