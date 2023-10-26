<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Networks extends Endpoint
{
    protected const PATH = '/networks';

    public function list()
    {
        return $this->client->get(self::PATH);
    }

    public function inspect(string $id)
    {
        return $this->client->get(self::PATH."/{$id}");
    }

    public function remove(string $id)
    {
        return $this->client->delete(self::PATH."/{$id}");
    }

    public function create(string $id)
    {
        return $this->client->post(self::PATH.'/create');
    }

    public function attachToContainer(string $id)
    {
        return $this->client->post(self::PATH."/{$id}/connect");
    }

    public function removeFromContainer(string $id)
    {
        return $this->client->post(self::PATH."/{$id}/disconnect");
    }

    public function prune()
    {
        return $this->client->post(self::PATH.'/prune');
    }
}
