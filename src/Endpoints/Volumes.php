<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Volumes extends Endpoint
{
    protected const PATH = '/volumes';

    public function list()
    {
        return $this->client->get(self::PATH);
    }

    public function create()
    {
        return $this->client->post(self::PATH.'/create');
    }

    public function inspect(string $name)
    {
        return $this->client->get(self::PATH."/{$name}");
    }

    public function update(string $name)
    {
        return $this->client->put(self::PATH."/{$name}");
    }

    public function remove(string $name)
    {
        return $this->client->delete(self::PATH."/{$name}");
    }

    public function prune()
    {
        return $this->client->post(self::PATH.'/prune');
    }
}
