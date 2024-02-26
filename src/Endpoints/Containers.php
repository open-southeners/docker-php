<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\ApiClient;
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
use OpenSoutheners\Docker\Serialize\DockerStream;

class Containers extends Endpoint
{
    protected const PATH = '/containers';

    public function list(?ContainersListQuery $query = null): mixed
    {
        return $this->client->get(self::PATH . '/json', $query ?? []);
    }

    public function create(array $body, ?string $name = null, string $arch = ''): mixed
    {
        return $this->client->post(self::PATH . '/create', $body, compact('name', 'arch'));
    }

    public function inspect(string $id, ?ContainersInspectQuery $query): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/json", $query ?? []);
    }

    public function top(string $id, ?ContainersTopQuery $query): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/top", $query ?? []);
    }

    public function logs(string $id, ?ContainersLogsQuery $query): DockerStream
    {
        return $this->client->contentType(ApiClient::MULTIPLEXED_DOCKER_STREAM_CONTENT_TYPE)
            ->get(self::PATH . "/{$id}/logs", $query ?? []);
    }

    public function changes(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/changes");
    }

    public function export(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/export");
    }

    public function stats(string $id, ?ContainersStatsQuery $query = null): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/stats", $query ?? []);
    }

    public function start(string $id, ?ContainersStartQuery $query = null): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/start", $query ?? []);
    }

    public function stop(string $id, ?ContainersStopQuery $query = null): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/stop", $query ?? []);
    }

    public function restart(string $id, ?ContainersRestartQuery $query = null): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/restart", $query ?? []);
    }

    public function kill(string $id, ?ContainersKillQuery $query = null): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/kill", $query ?? []);
    }

    public function update(string $id, array $body): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/update", $body);
    }

    public function rename(string $id, ContainersRenameQuery $query): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/rename", null, $query->toArray());
    }

    public function pause(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/pause");
    }

    public function unpause(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/unpause");
    }

    // TODO: Attach
    // @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerAttach

    public function wait(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/wait");
    }

    public function remove(string $id): mixed
    {
        return $this->client->contentType(ApiClient::RAW_CONTENT_TYPE)
            ->delete(self::PATH . "/{$id}");
    }

    public function filesystem(string $id): mixed
    {
        return $this->client->head(self::PATH . "/{$id}/archive");
    }

    public function backupFiles(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/archive");
    }

    public function uploadFiles(string $id): mixed
    {
        return $this->client->put(self::PATH . "/{$id}/archive");
    }

    public function prune(): mixed
    {
        return $this->client->post(self::PATH . '/prune');
    }
}
