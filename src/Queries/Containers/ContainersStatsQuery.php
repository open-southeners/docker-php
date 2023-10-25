<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersStatsQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerStats
     * 
     * @param bool|null $stream Stream the output. If false, the stats will be output once and then it will disconnect.
     * @param bool|null $oneShot Only get a single stat instead of waiting for 2 cycles. Must be used with stream=false.
     */
    public function __construct(
        public bool|null $stream = null,
        public bool|null $oneShot = null,
    ) {
        // 
    }
}
