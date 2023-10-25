<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersStartQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerStart
     * 
     * @param string|null $detachKeys Override the key sequence for detaching a container. Format is a single character [a-Z] or ctrl-<value> where <value> is one of: a-z, @, ^, [, , or _.
     */
    public function __construct(
        public string|null $detachKeys = null,
    ) {
        // 
    }
}
