<?php

namespace OpenSoutheners\Docker\Compose;

class ServicePort
{
    public function __construct(
        public int $published,
        public int|null $target = null,
        public int|null $toPublished = null,
        public int|null $toTarget = null,
        public string|null $machineIp = null,
        public string|null $protocol = null,
        public string|null $mode = null
    ) {
        //
    }

    public function getPublished(): int|string
    {
        $publishedPorts = $this->published;

        if ($this->toPublished) {
            $publishedPorts .= "-{$this->toPublished}";
        }

        return $publishedPorts;
    }

    public function getTarget(): int|string|null
    {
        $targetPorts = $this->target;

        if ($this->toTarget) {
            $targetPorts .= "-{$this->toTarget}";
        }

        return $targetPorts;
    }

    public function toArray(): array
    {
        return array_filter([
            'target' => $this->getTarget(),
            'published' => $this->getPublished(),
            'protocol' => $this->protocol,
            'mode' => $this->mode,
        ]);
    }

    public function __toString()
    {
        $targetRange = $this->getTarget();
        $publishedRange = $this->getPublished();

        $stringified = implode(':', array_filter([$this->machineIp, $publishedRange, $targetRange]));

        if ($this->mode) {
            $stringified .= "/{$this->mode}";
        }

        return $stringified;
    }
}
