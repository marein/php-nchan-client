<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Response;

final class HttpStreamWrapperResponse implements Response
{
    private int $statusCode;

    private string $body;

    public function __construct(int $statusCode, string $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * @param array<int, string> $headers The result from $http_response_header.
     *
     * @throws NchanException
     */
    public static function fromResponse(array $headers, string $body): HttpStreamWrapperResponse
    {
        // The first array value is for example "HTTP\1.1 200 OK" and must be set.
        if (!isset($headers[0])) {
            throw new NchanException('Unable to parse response header.');
        }

        // Get the status code.
        preg_match('/HTTP[^ ]+ (\d+)/', $headers[0], $matches);

        if (!isset($matches[1])) {
            throw new NchanException('Unable to retrieve status code from response header.');
        }

        $statusCode = (int)$matches[1];

        return new self(
            $statusCode,
            $body
        );
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function body(): string
    {
        return $this->body;
    }
}
