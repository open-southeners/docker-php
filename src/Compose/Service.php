<?php

namespace OpenSoutheners\Docker\Compose;

final class Service
{
    /**
     * @param string|null $name
     * @param string|null $image
     * @param array|null $build
     * @param array<\OpenSoutheners\Docker\Compose\ServicePort>|null $ports
     * @param array|null $labels
     */
    public function __construct(
        public string|null $name = null,
        public string|null $image = null,
        public array|null $build = [],
        public array|null $ports = [],
        public array|null $labels = [],
    ) {
        //
    }

    public function toArray()
    {
        return array_filter([
            'name' => $this->name,
            'image' => $this->image,
            'build' => $this->build,
            'ports' => array_map(fn(ServicePort $port) => $port->mode ? $port->toArray() : (string) $port, $this->ports),
            'labels' => $this->labels,
        ]);
    }
}
