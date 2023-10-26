<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Services;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesServices
{
    protected Services $services;

    public function getServices()
    {
        return $this->services->list();
    }

    public function createService()
    {
        return $this->services->create();
    }

    public function getService(string $id)
    {
        return $this->services->inspect($id);
    }

    public function removeService(string $id)
    {
        return $this->services->remove($id);
    }

    public function updateService(string $id)
    {
        return $this->services->update($id);
    }

    public function getServiceLogs(string $id)
    {
        return $this->services->logs($id);
    }
}
