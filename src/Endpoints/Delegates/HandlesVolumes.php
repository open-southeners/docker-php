<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Volumes;

trait HandlesVolumes
{
    protected Volumes $volumes;

    public function getVolumes()
    {
        return $this->volumes->list();
    }

    public function createVolume()
    {
        return $this->volumes->create();
    }

    public function getVolume(string $name)
    {
        return $this->volumes->inspect($name);
    }

    public function updateVolume(string $name)
    {
        return $this->volumes->update($name);
    }

    public function removeVolume(string $name)
    {
        return $this->volumes->remove($name);
    }

    public function pruneUnusedVolumes()
    {
        return $this->volumes->prune();
    }
}
