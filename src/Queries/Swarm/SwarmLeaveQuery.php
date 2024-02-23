<?php

namespace OpenSoutheners\Docker\Queries\Swarm;

use OpenSoutheners\Docker\RequestQuery;

class SwarmLeaveQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerInspect
     *
     * @param  bool  $force  Force leave swarm, even if this is the last manager or that it will break the cluster.
     */
    public function __construct(public bool $force = false)
    {
        //
    }
}
