<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\System;
use OpenSoutheners\Docker\Queries\System\SystemEventsQuery;
use OpenSoutheners\Docker\Queries\System\SystemStorageUsageQuery;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesSystem
{
    protected System $system;

    public function getSystemInfo(): mixed
    {
        return $this->system->info();
    }

    public function getVersion(): mixed
    {
        return $this->system->version();
    }

    public function ping(bool $usingHead = true): mixed
    {
        return $this->system->ping($usingHead);
    }

    public function getSystemEvents(SystemEventsQuery $query = null): mixed
    {
        return $this->system->events($query);
    }

    public function getStorageUsage(SystemStorageUsageQuery $query = null): mixed
    {
        return $this->system->dataUsage($query);
    }
}
