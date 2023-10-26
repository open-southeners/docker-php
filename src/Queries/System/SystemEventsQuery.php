<?php

namespace OpenSoutheners\Docker\Queries\System;

use OpenSoutheners\Docker\RequestQuery;

class SystemEventsQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/System/operation/SystemEvents
     *
     * @param  string|null  $since Show events created since this timestamp then stream new events.
     * @param  string|null  $until Show events created until this timestamp then stop streaming.
     * @param  array|null  $filters A JSON encoded value of filters (a map[string][]string) to process on the event list.
     */
    public function __construct(
        public ?string $since = null,
        public ?string $until = null,
        public ?array $filters = null
    ) {
        //
    }
}
