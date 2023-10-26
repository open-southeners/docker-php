<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Secrets;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesSecrets
{
    protected Secrets $secrets;

    public function getSecrets()
    {
        return $this->secrets->list();
    }

    public function createSecret()
    {
        return $this->secrets->create();
    }

    public function getSecret(string $id)
    {
        return $this->secrets->inspect($id);
    }

    public function removeSecret(string $id)
    {
        return $this->secrets->remove($id);
    }

    public function updateSecret(string $id)
    {
        return $this->secrets->update($id);
    }
}
