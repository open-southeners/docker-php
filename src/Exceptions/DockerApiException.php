<?php

namespace OpenSoutheners\Docker\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class DockerApiException extends \Exception implements ClientExceptionInterface
{
    public static function fromResponse(ResponseInterface $response, array|string $responseBody)
    {
        $errorMessage = $response->getReasonPhrase();

        if ($responseBody) {
            $errorMessage = "({$response->getStatusCode()} {$errorMessage}) ";
            $errorMessage .= is_string($responseBody)
                ? $responseBody
                : ($responseBody['message'] ?? '');
        }

        return new static($errorMessage, $response->getStatusCode());
    }
}
