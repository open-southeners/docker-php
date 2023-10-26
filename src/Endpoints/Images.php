<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Images extends Endpoint
{
    protected const PATH = '/images';

    public function list()
    {
        return $this->client->get(self::PATH.'/json');
    }

    public function build()
    {
        return $this->client->post('/build');
    }

    public function pruneBuildCache()
    {
        return $this->client->post('/build/prune');
    }

    public function create()
    {
        return $this->client->post(self::PATH.'/images/create');
    }

    public function inspect(string $name)
    {
        return $this->client->post(self::PATH."/{$name}/json");
    }

    public function history(string $name)
    {
        return $this->client->get(self::PATH."/{$name}/history");
    }

    public function push(string $name)
    {
        return $this->client->post(self::PATH."/{$name}/push");
    }

    public function tag(string $name)
    {
        return $this->client->post(self::PATH."/{$name}/tag");
    }

    public function remove(string $name)
    {
        return $this->client->delete(self::PATH."/{$name}");
    }

    public function search()
    {
        return $this->client->get(self::PATH.'/search');
    }

    public function prune()
    {
        return $this->client->post(self::PATH.'/prune');
    }

    public function commit()
    {
        return $this->client->post('/commit');
    }

    public function export(string $name)
    {
        return $this->client->get(self::PATH."/{$name}/get");
    }

    public function exportMany()
    {
        return $this->client->get(self::PATH.'/get');
    }

    public function import()
    {
        return $this->client->post(self::PATH.'/load');
    }
}
