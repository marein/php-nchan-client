<?php

namespace Marein\Nchan\Http;

final class Request
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * Request constructor.
     *
     * @param string $url
     * @param array  $headers
     * @param string $body
     */
    public function __construct(string $url, array $headers, string $body = '')
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @return array
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