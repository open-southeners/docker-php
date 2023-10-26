<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersInspectQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerInspect
     *
     * @param  bool|null  $size Return the size of container as fields SizeRw and SizeRootFs
     */
    public function __construct(
        public ?bool $size = null
    ) {
        //
    }
}
