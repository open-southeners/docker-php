<?php

namespace OpenSoutheners\Docker;

use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\ContentLengthPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Client\HttpClient;
use Http\Client\Socket\Client as SocketClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

use function OpenSoutheners\LaravelHelpers\Utils\build_http_query;

class ApiClient
{
    public const JSON_CONTENT_TYPE = 'application/json';

    public const STREAM_CONTENT_TYPE = 'application/octet-stream';

    private HttpClient $client; 

    public function __construct(
        private string $baseUrl,
        private ?SocketClient $socket = null,
        private ?RequestFactoryInterface $requestFactory = null,
        private ?StreamFactoryInterface $streamFactory = null,
        private ?PluginClientFactory $pluginFactory = null,
        private array $headers = []
    ) {
        $this->requestFactory ??= Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory ??= Psr17FactoryDiscovery::findStreamFactory();

        $socket ??= new SocketClient($this->requestFactory, [
            'remote_socket' => 'unix:///var/run/docker.sock',
        ]);

        $this->pluginFactory ??= new PluginClientFactory;
        
        $this->client = $this->pluginFactory->createClient($socket, [
            new ContentLengthPlugin(),
            new DecoderPlugin(),
        ]);
    }

    public function get(string $path, array $params = [])
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            $this->baseUrl.$path.build_http_query($params)
        );

        return $this->executeRequest($request);
    }

    public function head(string $path)
    {
        $request = $this->requestFactory->createRequest(
            'HEAD',
            $this->baseUrl.$path
        );

        return $this->executeRequest($request);
    }

    public function post(string $path, $body = null, array $params = [], string $contentType = null)
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'POST',
            $this->baseUrl.$path.build_http_query($params)
        )->withBody($this->getParsedBody($body));

        return $this->executeRequest($request);
    }

    public function contentType(string $value): static
    {
        return $this->usingHeader('Content-Type', $value);
    }

    public function usingHeader(string $header, string $value): static
    {
        $this->headers[$header] = $value;

        return $this;
    }

    private function executeRequest(RequestInterface $request)
    {
        foreach ($this->headers as $header => $value) {
            $request = $request->withAddedHeader($header, $value);
        }

        try {
            return $this->parseResponse($this->client->sendRequest($request));
        } catch (NetworkExceptionInterface $e) {
            // TODO:
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get parsed body using Content-Type header.
     */
    private function getParsedBody(mixed $body): mixed
    {
        return match ($this->headers['Content-Type'] ?? null) {
            static::JSON_CONTENT_TYPE => json_encode($body),
            // TODO:
            // static::STREAM_CONTENT_TYPE => 
            default => $body,
        };
    }

    private function parseResponse(ResponseInterface $response)
    {
        
        if (204 === $response->getStatusCode()) {
            return null;
        }

        if (! in_array('application/json', $response->getHeader('content-type'), true)) {
            // TODO:
            throw new \Exception($response->getBody()->getContents());
        }

        $deserialisedJsonBody = json_decode($response->getBody()->getContents(), true);

        dump($response->getStatusCode());
        if ($response->getStatusCode() >= 300) {
            // TODO:
            throw new \Exception($response->getReasonPhrase());
        }

        return $deserialisedJsonBody;
    }
}
