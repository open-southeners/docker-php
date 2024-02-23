<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Configs;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesConfigs
{
    protected Configs $configs;

    public function getConfigs(): mixed
    {
        return $this->configs->list();
    }

    public function createConfig(): mixed
    {
        return $this->configs->create();
    }

    public function getConfig(string $id): mixed
    {
        return $this->configs->inspect($id);
    }

    public function removeConfig(string $id): mixed
    {
        return $this->configs->remove($id);
    }

    public function updateConfig(string $id): mixed
    {
        return $this->configs->update($id);
    }
}
