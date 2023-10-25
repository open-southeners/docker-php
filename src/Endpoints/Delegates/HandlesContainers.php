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

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesContainers
{
    protected Containers $containers;

    public function getContainers(?ContainersListQuery $query = null)
    {
        return $this->containers->list($query);
    }

    public function createContainer(array $body)
    {
        return $this->containers->create($body);
    }
    
    public function getContainer(string $id, ?ContainersInspectQuery $query = null)
    {
        return $this->containers->inspect($id, $query);
    }
    
    public function getContainerProcesses(string $id, ?ContainersTopQuery $query = null)
    {
        return $this->containers->top($id, $query);
    }

    public function getContainerLogs(string $id, ?ContainersLogsQuery $query = null)
    {
        return $this->containers->logs($id, $query);
    }

    public function getContainerChanges(string $id)
    {
        return $this->containers->changes($id);
    }

    public function exportContainer(string $id)
    {
        return $this->containers->export($id);
    }

    public function getContainerStats(string $id, ?ContainersStatsQuery $query = null)
    {
        return $this->containers->stats($id, $query);
    }

    public function startContainer(string $id, ?ContainersStartQuery $query = null)
    {
        return $this->containers->start($id, $query);
    }

    public function stopContainer(string $id, ?ContainersStopQuery $query = null)
    {
        return $this->containers->stop($id, $query);
    }

    public function restartContainer(string $id, ?ContainersRestartQuery $query = null)
    {
        return $this->containers->restart($id, $query);
    }

    public function killContainer(string $id, ?ContainersKillQuery $query = null)
    {
        return $this->containers->kill($id, $query);
    }

    public function updateContainer(string $id, array $body)
    {
        return $this->containers->update($id, $body);
    }

    public function renameContainer(string $id, ContainersRenameQuery $query)
    {
        return $this->containers->rename($id, $query);
    }

    public function pauseContainer(string $id)
    {
        return $this->containers->pause($id);
    }

    public function unpauseContainer(string $id)
    {
        return $this->containers->unpause($id);
    }
}
