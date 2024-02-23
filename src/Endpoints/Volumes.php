<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Volumes extends Endpoint
{
    protected const PATH = '/volumes';

    public function list(): mixed
    {
        return $this->client->get(self::PATH);
    }

    public function create(): mixed
    {
        return $this->client->post(self::PATH . '/create');
    }

    public function inspect(string $name): mixed
    {
        return $this->client->get(self::PATH . "/{$name}");
    }

    public function update(string $name): mixed
    {
        return $this->client->put(self::PATH . "/{$name}");
    }

    public function remove(string $name): mixed
    {
        return $this->client->delete(self::PATH . "/{$name}");
    }

    public function prune(): mixed
    {
        return $this->client->post(self::PATH . '/prune');
    }
}
