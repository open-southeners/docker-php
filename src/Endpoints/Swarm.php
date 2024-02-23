<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;
use OpenSoutheners\Docker\Queries\Swarm\SwarmLeaveQuery;

class Swarm extends Endpoint
{
    protected const PATH = '/swarm';

    public function inspect(): mixed
    {
        return $this->client->get(self::PATH);
    }

    public function init(): mixed
    {
        return $this->client->post(self::PATH . '/init');
    }

    public function join(): mixed
    {
        return $this->client->post(self::PATH . '/join');
    }

    public function leave(?SwarmLeaveQuery $query = null): mixed
    {
        return $this->client->post(self::PATH . '/leave');
    }

    public function update(): mixed
    {
        return $this->client->post(self::PATH . '/update');
    }

    public function keyToUnlock(): mixed
    {
        return $this->client->get(self::PATH . '/unlockkey');
    }

    public function unlock(): mixed
    {
        return $this->client->post(self::PATH . '/unlock');
    }
}
