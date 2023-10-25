<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersKillQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerKill
     * 
     * @param string|null $signal Signal to send to the container as an integer or string (e.g. SIGINT).
     */
    public function __construct(
        public string|null $signal = null
    ) {
        // 
    }
}
