<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Configs;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesConfigs
{
    protected Configs $configs;

    public function getConfigs()
    {
        return $this->configs->list();
    }

    public function createConfig()
    {
        return $this->configs->create();
    }

    public function getConfig(string $id)
    {
        return $this->configs->inspect($id);
    }

    public function removeConfig(string $id)
    {
        return $this->configs->remove($id);
    }

    public function updateConfig(string $id)
    {
        return $this->configs->update($id);
    }
}
