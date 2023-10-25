<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersRestartQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerRestart
     * 
     * @param string|null $signal Signal to send to the container as an integer or string (e.g. SIGINT).
     * @param int|null $t Number of seconds to wait before killing the container
     */
    public function __construct(
        public string|null $signal = null,
        public int|null $t = null,
    ) {
        // 
    }
}
