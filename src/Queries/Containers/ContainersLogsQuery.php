<?php

namespace OpenSoutheners\Docker\Queries\Containers;

use OpenSoutheners\Docker\RequestQuery;

class ContainersLogsQuery extends RequestQuery
{
    /**
     * @see https://docs.docker.com/engine/api/v1.42/#tag/Container/operation/ContainerLogs
     * 
     * @param bool|null $follow Keep connection after returning logs.
     * @param bool|null $stdout Return logs from stdout
     * @param bool|null $stderr Return logs from stderr
     * @param int|null $since Only return logs since this time, as a UNIX timestamp
     * @param int|null $until Only return logs before this time, as a UNIX timestamp
     * @param bool|null $timestamps Add timestamps to every log line
     * @param string|null $tail Only return this number of log lines from the end of the logs. Specify as an integer or all to output all log lines.
     */
    public function __construct(
        public bool|null $follow = null,
        public bool|null $stdout = null,
        public bool|null $stderr = null,
        public int|null $since = null,
        public int|null $until = null,
        public bool|null $timestamps = null,
        public string|null $tail = null,
    ) {
        // 
    }
}
