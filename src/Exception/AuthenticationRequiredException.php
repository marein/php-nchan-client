<?php

namespace Marein\Nchan\Exception;

use Marein\Nchan\Http\Response;

final class AuthenticationRequiredException extends NchanException
{
    /**
     * Throws itself on status code 403.
     *
     * @param Response $response
     * @param string   $message
     *
     * @throws AuthenticationRequiredException
     */
    public static function throwIfResponseIsForbidden(Response $response, string $message): void
    {
        if ($response->statusCode() === Response::FORBIDDEN) {
            throw new self($message);
        }
    }
}