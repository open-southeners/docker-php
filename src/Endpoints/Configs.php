<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Configs extends Endpoint
{
    protected const PATH = '/configs';

    public function list()
    {
        return $this->client->get(self::PATH);
    }

    public function create()
    {
        return $this->client->post(self::PATH.'/create');
    }

    public function inspect(string $id)
    {
        return $this->client->get(self::PATH."/{$id}");
    }

    public function remove(string $id)
    {
        return $this->client->delete(self::PATH."/{$id}");
    }

    public function update(string $id)
    {
        return $this->client->post(self::PATH."/{$id}/update");
    }
}
