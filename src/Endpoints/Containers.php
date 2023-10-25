<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;
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

class Containers extends Endpoint
{
    protected const PATH = '/containers';

    public function list(?ContainersListQuery $query = null)
    {
        return $this->client->get(self::PATH.'/json', $query ? $query->toArray() : []);
    }

    public function create(array $body)
    {
        return $this->client->post(self::PATH.'/create', $body);
    }

    public function inspect(string $id, ?ContainersInspectQuery $query = null)
    {
        return $this->client->get(self::PATH."/{$id}/json", $query ? $query->toArray() : []);
    }

    public function top(string $id, ?ContainersTopQuery $query = null)
    {
        return $this->client->get(self::PATH."/{$id}/top", $query ? $query->toArray() : []);
    }

    public function logs(string $id, ?ContainersLogsQuery $query = null)
    {
        return $this->client->get(self::PATH."/{$id}/logs", $query ? $query->toArray() : []);
    }

    public function changes(string $id)
    {
        return $this->client->get(self::PATH."/{$id}/changes");
    }

    public function export(string $id)
    {
        return $this->client->get(self::PATH."/{$id}/export");
    }

    public function stats(string $id, ?ContainersStatsQuery $query = null)
    {
        return $this->client->get(self::PATH."/{$id}/stats", $query ? $query->toArray() : []);
    }

    public function start(string $id, ?ContainersStartQuery $query = null)
    {
        return $this->client->post(self::PATH."/{$id}/start", $query ? $query->toArray() : []);
    }

    public function stop(string $id, ?ContainersStopQuery $query = null)
    {
        return $this->client->post(self::PATH."/{$id}/stop", $query ? $query->toArray() : []);
    }

    public function restart(string $id, ?ContainersRestartQuery $query = null)
    {
        return $this->client->post(self::PATH."/{$id}/restart", $query ? $query->toArray() : []);
    }

    public function kill(string $id, ?ContainersKillQuery $query = null)
    {
        return $this->client->post(self::PATH."/{$id}/kill", $query ? $query->toArray() : []);
    }

    public function update(string $id, array $body)
    {
        return $this->client->post(self::PATH."/{$id}/update", $body);
    }

    public function rename(string $id, ContainersRenameQuery $query)
    {
        return $this->client->post(self::PATH."/{$id}/rename", null, $query->toArray());
    }

    public function pause(string $id)
    {
        return $this->client->post(self::PATH."/{$id}/pause");
    }

    public function unpause(string $id)
    {
        return $this->client->post(self::PATH."/{$id}/unpause");
    }
}
