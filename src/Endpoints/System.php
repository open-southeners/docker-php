<?php

namespace OpenSoutheners\Docker\Endpoints;

use OpenSoutheners\Docker\Endpoint;
use OpenSoutheners\Docker\Queries\System\SystemEventsQuery;
use OpenSoutheners\Docker\Queries\System\SystemStorageUsageQuery;

class System extends Endpoint
{
    public function info()
    {
        return $this->client->get('/info');
    }

    public function version()
    {
        return $this->client->get('/version');
    }

    public function ping(bool $usingHead = true)
    {
        return $usingHead ? $this->client->head('/_ping') : $this->client->get('/_ping');
    }

    public function events(?SystemEventsQuery $query = null)
    {
        return $this->client->get('/events', $query ? $query->toArray() : []);
    }

    public function dataUsage(?SystemStorageUsageQuery $query = null)
    {
        return $this->client->get('/system/df', $query ? $query->toArray() : []);
    }
}
