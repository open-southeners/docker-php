<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Secrets;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesSecrets
{
    protected Secrets $secrets;

    public function getSecrets(): mixed
    {
        return $this->secrets->list();
    }

    public function createSecret(): mixed
    {
        return $this->secrets->create();
    }

    public function getSecret(string $id): mixed
    {
        return $this->secrets->inspect($id);
    }

    public function removeSecret(string $id): mixed
    {
        return $this->secrets->remove($id);
    }

    public function updateSecret(string $id): mixed
    {
        return $this->secrets->update($id);
    }
}
