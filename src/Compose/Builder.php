<?php

namespace OpenSoutheners\Docker\Compose;

use Symfony\Component\Yaml\Yaml;

class Builder
{
    public function __construct(
        protected string|null $fromComposeFile = null,
        protected string $version = '3',
        protected array $services = [],
        protected array $volumes = [],
        protected array $networks = []
    ) {
        $this->loadFromFile();
    }

    protected function loadFromFile(): void
    {
        if (! $this->fromComposeFile) {
            return;
        }

        $parsedCompose = Yaml::parseFile($this->fromComposeFile);

        foreach ($parsedCompose['services'] ?? [] as $id => $service) {
            $this->newServiceBuilder()->fromArray($service)->add($this, $id);
        }
    }

    public function toFile(string $filePath = null): void
    {
        //
    }

    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'services' => array_map(fn(Service $service) => $service->toArray(), $this->services),
        ];
    }

    public function toYaml(int $indentation = 2)
    {
        return Yaml::dump($this->toArray(), 9999, $indentation);
    }

    public function newServiceBuilder(): ServiceBuilder
    {
        return new ServiceBuilder();
    }

    public function addService(string $id, Service $service): self
    {
        $this->services[$id] = $service;

        return $this;
    }
}
