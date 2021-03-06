<?php
declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Response;

final class HttpStreamWrapperResponse implements Response
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     */
    private string $body;

    /**
     * HttpStreamWrapperResponse constructor.
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
     * Create a HttpStreamWrapperResponse object from $http_response_header and file_get_contents result.
     *
     * @param array<int, string> $headers The result from $http_response_header.
     * @param string             $body    The result from file_get_contents.
     *
     * @return HttpStreamWrapperResponse
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
