<?php

namespace OpenSoutheners\Docker\Serialize;

use Psr\Http\Message\StreamInterface;

class DockerStream
{
    public function __construct(
        protected StreamInterface $stream,
        protected array $onStdinCallables = [],
        protected array $onStdoutCallables = [],
        protected array $onStderrCallables = []
    ) {}

    /**
     * Add a callable to read stdin.
     */
    public function onStdin(callable $callback): self
    {
        $this->onStdinCallables[] = $callback;

        return $this;
    }

    /**
     * Add a callable to read stdout.
     */
    public function onStdout(callable $callback): self
    {
        $this->onStdoutCallables[] = $callback;

        return $this;
    }

    /**
     * Add a callable to read stderr.
     */
    public function onStderr(callable $callback): self
    {
        $this->onStderrCallables[] = $callback;

        return $this;
    }

    public function readFrame(): void
    {
        $header = $this->stream->read(8);

        if (! $header) {
            return;
        }

        $decoded = unpack('C1type/C3/N1size', $header);

        if (! $decoded) {
            return;
        }

        $output = $this->forceRead($decoded['size']);

        $callbackList = match ($decoded['type']) {
            0 => $this->onStdinCallables,
            1 => $this->onStdoutCallables,
            2 => $this->onStderrCallables,
            default => [],
        };

        foreach ($callbackList as $callback) {
            $callback($output);
        }
    }

    /**
     * Force to have something of the expected size (block).
     */
    private function forceRead(int $length): string
    {
        $read = '';

        do {
            $read .= $this->stream->read($length - \strlen($read));
        } while (\strlen($read) < $length && ! $this->stream->eof());

        return $read;
    }

    /**
     * Wait for stream to finish and call callables if defined.
     */
    public function wait(): void
    {
        while (! $this->stream->eof()) {
            $this->readFrame();
        }
    }
}
