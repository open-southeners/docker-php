<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Tasks;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesTasks
{
    protected Tasks $tasks;

    public function getTasks()
    {
        return $this->tasks->list();
    }

    public function getTask(string $id)
    {
        return $this->tasks->inspect($id);
    }

    public function getTaskLogs(string $id)
    {
        return $this->tasks->logs($id);
    }
}
