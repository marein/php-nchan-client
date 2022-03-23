<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Response;
use Psr\Http\Message\ResponseInterface;

final class Psr7ResponseAdapter implements Response
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function statusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function body(): string
    {
        return (string)$this->response->getBody();
    }
}
