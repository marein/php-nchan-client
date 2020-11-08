<?php
declare(strict_types=1);

namespace Marein\Nchan\Http;

final class Request
{
    /**
     * @var Url
     */
    private Url $url;

    /**
     * @var array<string, string>
     */
    private array $headers;

    /**
     * @var string
     */
    private string $body;

    /**
     * Request constructor.
     *
     * @param Url                   $url
     * @param array<string, string> $headers
     * @param string                $body
     */
    public function __construct(Url $url, array $headers, string $body = '')
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return Url
     */
    public function url(): Url
    {
        return $this->url;
    }

    /**
     * @return array<string, string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}
