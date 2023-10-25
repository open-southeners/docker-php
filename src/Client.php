<?php

namespace OpenSoutheners\Docker;

use OpenSoutheners\Docker\Endpoints\Containers;
use OpenSoutheners\Docker\ApiClient;
use Http\Client\Socket\Client as SocketClient;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesContainers;
use OpenSoutheners\Docker\Endpoints\Delegates\HandlesSystem;
use OpenSoutheners\Docker\Endpoints\System;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Client
{
    use HandlesContainers;
    use HandlesSystem;
    use HandlesContainers;

    public const DOCKER_API_VERSION = 'v1.42';

    protected ApiClient $apiClient;

    public function __construct(
        string $url,
        SocketClient $socketClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->apiClient = new ApiClient(
            $url.'/'.static::DOCKER_API_VERSION,
            $socketClient,
            $requestFactory,
            $streamFactory
        );
        
        $this->containers = new Containers($this->apiClient);
        $this->system = new System($this->apiClient);
    }
}
