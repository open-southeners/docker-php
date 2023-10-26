<?php

namespace OpenSoutheners\Docker;

abstract class Endpoint
{
    protected const PATH = '';

    public function __construct(protected ApiClient $client)
    {
        //
    }
}
