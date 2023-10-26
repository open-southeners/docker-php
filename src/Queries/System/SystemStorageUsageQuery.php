<?php

namespace OpenSoutheners\Docker\Queries\System;

use OpenSoutheners\Docker\RequestQuery;

class SystemStorageUsageQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/System/operation/SystemDataUsage
     *
     * @param  string|null  $type Object types, for which to compute and return data.
     */
    public function __construct(
        public ?string $type = null
    ) {
        //
    }
}
