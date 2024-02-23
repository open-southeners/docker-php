<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Tasks extends Endpoint
{
    protected const PATH = '/tasks';

    public function list(): mixed
    {
        return $this->client->get(self::PATH);
    }

    public function inspect(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}");
    }

    public function logs(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}/logs");
    }
}
