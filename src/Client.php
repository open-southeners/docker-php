<?php

namespace OpenSoutheners\Docker;

use Http\Client\Socket\Client as SocketClient;
use OpenSoutheners\Docker\Compose\Builder;
use OpenSoutheners\Docker\Endpoints\Configs;
use OpenSoutheners\Docker\Endpoints\Containers;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesConfigs;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesContainers;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesImages;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesNetworks;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesNodes;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesSecrets;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesServices;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesSwarm;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesSystem;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesTasks;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesVolumes;
use OpenSoutheners\Docker\Endpoints\Images;
use OpenSoutheners\Docker\Endpoints\Networks;
use OpenSoutheners\Docker\Endpoints\Nodes;
use OpenSoutheners\Docker\Endpoints\Secrets;
use OpenSoutheners\Docker\Endpoints\Services;
use OpenSoutheners\Docker\Endpoints\Swarm;
use OpenSoutheners\Docker\Endpoints\System;
use OpenSoutheners\Docker\Endpoints\Tasks;
use OpenSoutheners\Docker\Endpoints\Volumes;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Client
{
    use HandlesConfigs;
    use HandlesContainers;
    use HandlesImages;
    use HandlesNetworks;
    use HandlesNodes;
    use HandlesSecrets;
    use HandlesServices;
    use HandlesSwarm;
    use HandlesSystem;
    use HandlesTasks;
    use HandlesVolumes;

    public const DOCKER_API_VERSION = 'v1.42';

    protected ApiClient $apiClient;

    public function __construct(
        string $url,
        SocketClient $socketClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->apiClient = new ApiClient(
            $url . '/' . static::DOCKER_API_VERSION,
            $socketClient,
            $requestFactory,
            $streamFactory
        );

        $this->containers = new Containers($this->apiClient);
        $this->images = new Images($this->apiClient);
        $this->networks = new Networks($this->apiClient);
        $this->volumes = new Volumes($this->apiClient);
        $this->swarm = new Swarm($this->apiClient);
        $this->nodes = new Nodes($this->apiClient);
        $this->services = new Services($this->apiClient);
        $this->tasks = new Tasks($this->apiClient);
        $this->secrets = new Secrets($this->apiClient);
        $this->configs = new Configs($this->apiClient);
        $this->system = new System($this->apiClient);
    }

    public function compose(string $file = null): Builder
    {
        return new Builder($file);
    }
}
