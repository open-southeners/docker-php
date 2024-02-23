<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Networks extends Endpoint
{
    protected const PATH = '/networks';

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

    public function create(string $id): mixed
    {
        return $this->client->post(self::PATH . '/create');
    }

    public function attachToContainer(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/connect");
    }

    public function removeFromContainer(string $id): mixed
    {
        return $this->client->post(self::PATH . "/{$id}/disconnect");
    }

    public function prune(): mixed
    {
        return $this->client->post(self::PATH . '/prune');
    }
}
