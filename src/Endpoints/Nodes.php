<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Nodes extends Endpoint
{
    protected const PATH = '/nodes';

    public function list(): mixed
    {
        return $this->client->get(self::PATH);
    }

    public function inspect(string $id): mixed
    {
        return $this->client->get(self::PATH . "/{$id}");
    }

    public function remove(string $id): mixed
    {
        return $this->client->delete(self::PATH . "/{$id}");
    }

    public function update(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/update");
    }
}
