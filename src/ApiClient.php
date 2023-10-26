<?php

namespace OpenSoutheners\Docker;

use Http\Client\Common\Plugin\ContentLengthPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Client\HttpClient;
use Http\Client\Socket\Client as SocketClient;
use Http\Discovery\Psr17FactoryDiscovery;
use OpenSoutheners\Docker\Exceptions\DockerApiException;
use OpenSoutheners\Docker\Exceptions\UnacceptedResponseFormatting;
use OpenSoutheners\Docker\Serialize\DockerStream;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

use function OpenSoutheners\LaravelHelpers\Utils\build_http_query;

class ApiClient
{
    public const RAW_CONTENT_TYPE = 'text/raw';

    public const JSON_CONTENT_TYPE = 'application/json';

    public const STREAM_CONTENT_TYPE = 'application/octet-stream';

    public const MULTIPLEXED_DOCKER_STREAM_CONTENT_TYPE = 'application/vnd.docker.multiplexed-stream';

    public const RAW_DOCKER_STREAM_CONTENT_TYPE = 'application/vnd.docker.raw-stream';

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
        )->withBody($this->applySentBodyParsing($body));

        return $this->executeRequest($request);
    }

    public function put(string $path, $body = null, array $params = [], string $contentType = null)
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'PUT',
            $this->baseUrl.$path.build_http_query($params)
        )->withBody($this->applySentBodyParsing($body));

        return $this->executeRequest($request);
    }

    public function patch(string $path, $body = null, array $params = [], string $contentType = null)
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'PATCH',
            $this->baseUrl.$path.build_http_query($params)
        )->withBody($this->applySentBodyParsing($body));

        return $this->executeRequest($request);
    }

    public function delete(string $path, array $params = [])
    {
        $request = $this->requestFactory->createRequest(
            'DELETE',
            $this->baseUrl.$path.build_http_query($params)
        );

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
    private function applySentBodyParsing(mixed $body): mixed
    {
        return match ($this->headers['Content-Type'] ?? null) {
            static::JSON_CONTENT_TYPE => json_encode($body),
            static::RAW_CONTENT_TYPE => $body,
            // TODO:
            // static::STREAM_CONTENT_TYPE =>
            default => $body,
        };
    }

    /**
     * Get parsed body from response using Accept falling back to default.
     */
    private function applyResponseParsing(ResponseInterface $response): mixed
    {
        return match ($this->headers['Accept'] ?? $response->getHeader('Content-Type')[0]) {
            static::JSON_CONTENT_TYPE => json_decode($response->getBody()->getContents(), true),
            static::RAW_CONTENT_TYPE => $response->getBody()->getContents(),
            static::RAW_DOCKER_STREAM_CONTENT_TYPE => new DockerStream($response->getBody()),
            static::MULTIPLEXED_DOCKER_STREAM_CONTENT_TYPE => new DockerStream($response->getBody()),
            // TODO:
            // static::STREAM_CONTENT_TYPE =>
            // default => $response->getBody()->getContents(),
        };
    }

    private function parseResponse(ResponseInterface $response): mixed
    {
        if ($response->getStatusCode() === 204) {
            return null;
        }

        $acceptedContentType = $this->headers['Content-Type'] ?? self::JSON_CONTENT_TYPE;

        if (! in_array($acceptedContentType, $response->getHeader('content-type'), true)) {
            throw UnacceptedResponseFormatting::fromAccepted($acceptedContentType, $response);
        }

        $bodyContent = $this->applyResponseParsing($response);

        if ($response->getStatusCode() >= 300) {
            throw DockerApiException::fromResponse($response, $bodyContent);
        }

        return $bodyContent;
    }
}
