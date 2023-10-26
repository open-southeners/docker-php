<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Nodes;

trait HandlesNodes
{
    protected Nodes $nodes;

    public function getNodes()
    {
        return $this->nodes->list();
    }

    public function getNode(string $id)
    {
        return $this->nodes->inspect($id);
    }

    public function removeNode(string $id)
    {
        return $this->nodes->remove($id);
    }

    public function updateNode(string $id)
    {
        return $this->nodes->update($id);
    }
}
