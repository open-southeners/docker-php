<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersTopQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerTop
     *
     * @param  string  $ps_args The arguments to pass to ps. For example, aux
     */
    public function __construct(public ?string $ps_args = null)
    {
        //
    }
}
