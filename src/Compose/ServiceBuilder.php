<?php

namespace OpenSoutheners\Docker\Compose;

class ServiceBuilder
{
    public function __construct(
        protected ?Service $service = null
    ) {
        $this->service ??= new Service();
    }

    public function fromArray(array $data): self
    {
        $this->service = new Service(
            $data['name'] ?? null,
            $data['image'] ?? null,
            $data['build'] ?? null
        );

        foreach ($data['ports'] ?? [] as $port) {
            $portsArr = explode(':', $port);

            $this->addPort($portsArr[0], $portsArr[1] ?? null);
        }

        return $this;
    }

    public function addLabel(string $key, string $value): self
    {
        $this->service->labels[$key] = $value;

        return $this;
    }

    public function addPort(int|ServicePort $target, int|null $published = null): self
    {
        $this->service->ports[] = $target instanceof ServicePort ? $target : new ServicePort($target, $published);

        return $this;
    }

    public function add(Builder $composeBuilder, string $id): self
    {
        $composeBuilder->addService($id, $this->service);

        return $this;
    }
}
