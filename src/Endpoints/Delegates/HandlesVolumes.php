<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Volumes;

trait HandlesVolumes
{
    protected Volumes $volumes;

    public function getVolumes(): mixed
    {
        return $this->volumes->list();
    }

    public function createVolume(): mixed
    {
        return $this->volumes->create();
    }

    public function getVolume(string $name): mixed
    {
        return $this->volumes->inspect($name);
    }

    public function updateVolume(string $name): mixed
    {
        return $this->volumes->update($name);
    }

    public function removeVolume(string $name): mixed
    {
        return $this->volumes->remove($name);
    }

    public function pruneUnusedVolumes(): mixed
    {
        return $this->volumes->prune();
    }
}
