<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Images extends Endpoint
{
    protected const PATH = '/images';

    public function list(): mixed
    {
        return $this->client->get(self::PATH . '/json');
    }

    public function build(): mixed
    {
        return $this->client->post('/build');
    }

    public function pruneBuildCache(): mixed
    {
        return $this->client->post('/build/prune');
    }

    public function create(): mixed
    {
        return $this->client->post(self::PATH . '/images/create');
    }

    public function inspect(string $name): mixed
    {
        return $this->client->post(self::PATH . "/{$name}/json");
    }

    public function history(string $name): mixed
    {
        return $this->client->get(self::PATH . "/{$name}/history");
    }

    public function push(string $name): mixed
    {
        return $this->client->post(self::PATH . "/{$name}/push");
    }

    public function tag(string $name): mixed
    {
        return $this->client->post(self::PATH . "/{$name}/tag");
    }

    public function remove(string $name): mixed
    {
        return $this->client->delete(self::PATH . "/{$name}");
    }

    public function search(): mixed
    {
        return $this->client->get(self::PATH . '/search');
    }

    public function prune(): mixed
    {
        return $this->client->post(self::PATH . '/prune');
    }

    public function commit(): mixed
    {
        return $this->client->post('/commit');
    }

    public function export(string $name): mixed
    {
        return $this->client->get(self::PATH . "/{$name}/get");
    }

    public function exportMany(): mixed
    {
        return $this->client->get(self::PATH . '/get');
    }

    public function import(): mixed
    {
        return $this->client->post(self::PATH . '/load');
    }
}
