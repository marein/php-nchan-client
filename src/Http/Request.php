<?php

declare(strict_types=1);

namespace Marein\Nchan\Http;

final class Request
{
    private Url $url;

    /**
     * @var array<string, string>
     */
    private array $headers;

    private string $body;

    /**
     * @param array<string, string> $headers
     */
    public function __construct(Url $url, array $headers, string $body = '')
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

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

    public function body(): string
    {
        return $this->body;
    }
}
