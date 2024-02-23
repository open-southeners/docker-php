<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Services;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesServices
{
    protected Services $services;

    public function getServices(): mixed
    {
        return $this->services->list();
    }

    public function createService(): mixed
    {
        return $this->services->create();
    }

    public function getService(string $id): mixed
    {
        return $this->services->inspect($id);
    }

    public function removeService(string $id): mixed
    {
        return $this->services->remove($id);
    }

    public function updateService(string $id): mixed
    {
        return $this->services->update($id);
    }

    public function getServiceLogs(string $id): mixed
    {
        return $this->services->logs($id);
    }
}
