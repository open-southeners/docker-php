<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersListQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerList
     *
     * @param  bool|null  $all Return all containers. By default, only running containers are shown.
     * @param  int|null  $limit Return this number of most recently created containers, including non-running ones.
     * @param  bool|null  $size Return the size of container as fields SizeRw and SizeRootFs.
     * @param  array  $filters Filters to process on the container list, encoded as JSON
     */
    public function __construct(
        public ?bool $all = null,
        public ?int $limit = null,
        public ?bool $size = null,
        public array $filters = []
    ) {
        //
    }
}
