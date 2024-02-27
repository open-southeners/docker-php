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

use Psr\Http\Message\StreamInterface;

use function OpenSoutheners\LaravelHelpers\Utils\build_http_query;

class ApiClient
{
    public const RAW_CONTENT_TYPE = 'text/raw';

    public const JSON_CONTENT_TYPE = 'application/json';

    public const STREAM_CONTENT_TYPE = 'application/octet-stream';

    public const MULTIPLEXED_DOCKER_STREAM_CONTENT_TYPE = 'application/vnd.docker.multiplexed-stream';

    public const RAW_DOCKER_STREAM_CONTENT_TYPE = 'application/vnd.docker.raw-stream';

    private HttpClient $client;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        private string $baseUrl,
        SocketClient $socket = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null,
        PluginClientFactory $pluginFactory = null,
        private array $headers = []
    ) {
        $requestFactory ??= Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory ??= Psr17FactoryDiscovery::findStreamFactory();

        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;

        $socket ??= new SocketClient([
            'remote_socket' => 'unix:///var/run/docker.sock',
        ]);

        $pluginFactory ??= new PluginClientFactory();

        $this->client = $pluginFactory->createClient($socket, [
            new ContentLengthPlugin(),
            new DecoderPlugin(),
        ]);
    }

    private function queryToString(array|RequestQuery $params = []): string
    {
        return build_http_query(
            $params instanceof RequestQuery
                ? $params->toArray()
                : $params
        );
    }

    public function get(string $path, array|RequestQuery $params = []): mixed
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            $this->baseUrl . $path . $this->queryToString($params)
        );

        return $this->executeRequest($request);
    }

    public function head(string $path, array|RequestQuery $params = []): mixed
    {
        $request = $this->requestFactory->createRequest(
            'HEAD',
            $this->baseUrl . $path
        );

        return $this->executeRequest($request);
    }

    public function post(string $path, string|array|null $body = null, array|RequestQuery $params = [], ?string $contentType = null): mixed
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'POST',
            $this->baseUrl . $path . $this->queryToString($params)
        );

        if ($body) {
            $request->withBody($this->applySentBodyParsing($body));
        }

        return $this->executeRequest($request);
    }

    public function put(string $path, string|array|null $body = null, array|RequestQuery $params = [], ?string $contentType = null): mixed
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'PUT',
            $this->baseUrl . $path . $this->queryToString($params)
        );

        if ($body) {
            $request->withBody($this->applySentBodyParsing($body));
        }

        return $this->executeRequest($request);
    }

    public function patch(string $path, string|array|null $body = null, array|RequestQuery $params = [], ?string $contentType = null): mixed
    {
        $this->contentType($contentType ?? static::JSON_CONTENT_TYPE);

        $request = $this->requestFactory->createRequest(
            'PATCH',
            $this->baseUrl . $path . $this->queryToString($params)
        );

        if ($body) {
            $request->withBody($this->applySentBodyParsing($body));
        }

        return $this->executeRequest($request);
    }

    public function delete(string $path, string|array|null $body = null, array|RequestQuery $params = []): mixed
    {
        $request = $this->requestFactory->createRequest(
            'DELETE',
            $this->baseUrl . $path . $this->queryToString($params)
        );

        if ($body) {
            $request->withBody($this->applySentBodyParsing($body));
        }

        return $this->executeRequest($request);
    }

    public function contentType(string $value): static
    {
        return $this->usingHeader('Content-Type', $value);
    }

    public function acceptResponseType(string $value): static
    {
        return $this->usingHeader('Accept', $value);
    }

    public function usingHeader(string $header, string $value): static
    {
        $this->headers[$header] = $value;

        return $this;
    }

    private function executeRequest(RequestInterface $request): mixed
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
    private function applySentBodyParsing(string|array $body): StreamInterface
    {
        $parsedBody = match ($this->headers['Content-Type'] ?? null) {
            static::JSON_CONTENT_TYPE => json_encode($body),
            // TODO:
            // static::STREAM_CONTENT_TYPE =>
            default => is_array($body) ? json_encode($body) : $body,
        };

        if (! $parsedBody) {
            throw new \Exception('Body serialization format error, sent falsy or empty value.');
        }

        return $this->streamFactory->createStream($parsedBody);
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
        if (in_array($response->getStatusCode(), [204, 304], true)) {
            return null;
        }

        $acceptedContentType = $this->headers['Content-Type'] ?? self::JSON_CONTENT_TYPE;

        if (! in_array($acceptedContentType, $response->getHeader('content-type'), true)) {
            throw UnacceptedResponseFormatting::fromAccepted($acceptedContentType, $response);
        }

        $bodyContent = $this->applyResponseParsing($response);

        if ((is_string($bodyContent) || is_array($bodyContent)) && $response->getStatusCode() >= 300) {
            throw DockerApiException::fromResponse($response, $bodyContent);
        }

        return $bodyContent;
    }
}
