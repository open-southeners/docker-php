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
    ) {
        
    }

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

    public function readFrame()
    {
        $header = $this->stream->read(8);

        $decoded = unpack('C1type/C3/N1size', $header);
        $output = $this->forceRead($decoded['size']);

        if (0 === $decoded['type']) {
            $callbackList = $this->onStdinCallables;
        }

        if (1 === $decoded['type']) {
            $callbackList = $this->onStdoutCallables;
        }

        if (2 === $decoded['type']) {
            $callbackList = $this->onStderrCallables;
        }

        foreach ($callbackList as $callback) {
            $callback($output);
        }
    }

    /**
     * Force to have something of the expected size (block).
     *
     * @param $length
     *
     * @return string
     */
    private function forceRead($length)
    {
        $read = '';

        do {
            $read .= $this->stream->read($length - \strlen($read));
        } while (\strlen($read) < $length && !$this->stream->eof());

        return $read;
    }

    /**
     * Wait for stream to finish and call callables if defined.
     */
    public function wait(): void
    {
        while (!$this->stream->eof()) {
            $this->readFrame();
        }
    }
}
