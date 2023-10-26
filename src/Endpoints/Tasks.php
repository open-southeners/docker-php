<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Tasks extends Endpoint
{
    protected const PATH = '/tasks';

    public function list()
    {
        return $this->client->get(self::PATH);
    }

    public function inspect(string $id)
    {
        return $this->client->get(self::PATH."/{$id}");
    }

    public function logs(string $id)
    {
        return $this->client->get(self::PATH."/{$id}/logs");
    }
}
