<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;

class Swarm extends Endpoint
{
    protected const PATH = '/swarm';

    public function inspect()
    {
        return $this->client->get(self::PATH);
    }

    public function init()
    {
        return $this->client->post(self::PATH.'/init');
    }

    public function join()
    {
        return $this->client->post(self::PATH.'/join');
    }

    public function leave()
    {
        return $this->client->post(self::PATH.'/leave');
    }

    public function update()
    {
        return $this->client->post(self::PATH.'/update');
    }

    public function keyToUnlock()
    {
        return $this->client->get(self::PATH.'/unlockkey');
    }

    public function unlock()
    {
        return $this->client->post(self::PATH.'/unlock');
    }
}
