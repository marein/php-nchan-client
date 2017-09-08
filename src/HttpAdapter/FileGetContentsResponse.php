<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Response;

final class FileGetContentsResponse implements Response
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $body;

    /**
     * FileGetContentsResponse constructor.
     *
     * @param int    $statusCode
     * @param string $body
     */
    public function __construct(int $statusCode, string $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * @param array  $headers The result from $http_response_header.
     * @param string $body    The result from file_get_contents.
     *
     * @return FileGetContentsResponse
     * @throws NchanException
     */
    public static function fromResponse(array $headers, string $body): FileGetContentsResponse
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

    /**
     * @inheritdoc
     */
    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritdoc
     */
    public function body(): string
    {
        return $this->body;
    }
}