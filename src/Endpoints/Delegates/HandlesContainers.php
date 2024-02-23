<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Containers;
use OpenSoutheners\Docker\Queries\Containers\ContainersInspectQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersKillQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersListQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersLogsQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersRenameQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersRestartQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersStartQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersStatsQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersStopQuery;
use OpenSoutheners\Docker\Queries\Containers\ContainersTopQuery;
use OpenSoutheners\Docker\Serialize\DockerStream;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesContainers
{
    protected Containers $containers;

    public function getContainers(?ContainersListQuery $query = null): mixed
    {
        return $this->containers->list($query);
    }

    public function createContainer(array $body): mixed
    {
        return $this->containers->create($body);
    }

    public function getContainer(string $id, ?ContainersInspectQuery $query = null): mixed
    {
        return $this->containers->inspect($id, $query);
    }

    public function getContainerProcesses(string $id, ?ContainersTopQuery $query = null): mixed
    {
        return $this->containers->top($id, $query);
    }

    public function getContainerLogs(string $id, ?ContainersLogsQuery $query = null): DockerStream
    {
        return $this->containers->logs($id, $query);
    }

    public function getContainerChanges(string $id): mixed
    {
        return $this->containers->changes($id);
    }

    public function exportContainer(string $id): mixed
    {
        return $this->containers->export($id);
    }

    public function getContainerStats(string $id, ?ContainersStatsQuery $query = null): mixed
    {
        return $this->containers->stats($id, $query);
    }

    public function startContainer(string $id, ?ContainersStartQuery $query = null): mixed
    {
        return $this->containers->start($id, $query);
    }

    public function stopContainer(string $id, ?ContainersStopQuery $query = null): mixed
    {
        return $this->containers->stop($id, $query);
    }

    public function restartContainer(string $id, ?ContainersRestartQuery $query = null): mixed
    {
        return $this->containers->restart($id, $query);
    }

    public function killContainer(string $id, ?ContainersKillQuery $query = null): mixed
    {
        return $this->containers->kill($id, $query);
    }

    public function updateContainer(string $id, array $body): mixed
    {
        return $this->containers->update($id, $body);
    }

    public function renameContainer(string $id, ContainersRenameQuery $query): mixed
    {
        return $this->containers->rename($id, $query);
    }

    public function pauseContainer(string $id): mixed
    {
        return $this->containers->pause($id);
    }

    public function unpauseContainer(string $id): mixed
    {
        return $this->containers->unpause($id);
    }

    public function waitForContainer(string $id): mixed
    {
        return $this->containers->wait($id);
    }

    public function removeContainer(string $id): mixed
    {
        return $this->containers->remove($id);
    }

    public function getContainerFilesystemInfo(string $id): mixed
    {
        return $this->containers->filesystem($id);
    }

    public function backupFilesFromContainer(string $id): mixed
    {
        return $this->containers->backupFiles($id);
    }

    public function uploadFilesToContainer(string $id): mixed
    {
        return $this->containers->uploadFiles($id);
    }

    public function pruneContainers(): mixed
    {
        return $this->containers->prune();
    }
}
