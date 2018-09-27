<?php
declare(strict_types=1);

namespace Marein\Nchan\Http;

final class Request
{
    /**
     * @var Url
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
     * @param Url    $url
     * @param array  $headers
     * @param string $body
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
