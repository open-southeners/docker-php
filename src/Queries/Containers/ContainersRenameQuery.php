<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersRenameQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerRename
     *
     * @param  string  $name New name for the container
     */
    public function __construct(
        public string $name
    ) {
        //
    }
}
