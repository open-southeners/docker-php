<?php

namespace OpenSoutheners\Docker\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class UnacceptedResponseFormatting extends \Exception implements ClientExceptionInterface
{
    public const EXCEPTION_MESSAGE = 'The Docker API response formatted as "%s" did not match return format "%s".';

    public static function fromAccepted(string $contentType, ResponseInterface $response, \Throwable $previous = null)
    {
        return new static(sprintf(
            self::EXCEPTION_MESSAGE,
            implode(', ', $response->getHeader('Content-Type')),
            $contentType
        ), 406, $previous);
    }
}
