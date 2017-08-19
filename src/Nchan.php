<?php

namespace Marein\Nchan;

use Marein\Nchan\Api\Channel;
use Marein\Nchan\Api\Status;
use Marein\Nchan\Http\Adapter\FileGetContents;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Url;

final class Nchan
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Client
     */
    private $client;

    /**
     * Nchan constructor.
     *
     * @param string      $baseUrl
     * @param Client|null $client
     */
    public function __construct(string $baseUrl, Client $client = null)
    {
        $this->baseUrl = new Url($baseUrl);
        $client = $client ?: new FileGetContents();
        $this->client = $client;
    }

    /**
     * @param string $name
     *
     * @return Channel
     */
    public function channel(string $name): Channel
    {
        return new Channel($this->baseUrl->append($name), $this->client);
    }

    /**
     * @param string $path
     *
     * @return Status
     */
    public function status(string $path): Status
    {
        return new Status($this->baseUrl->append($path), $this->client);
    }

    /**
     * @param string $name
     *
     * @throws \Exception
     */
    public function group(string $name): void
    {
        throw new \Exception('Not implemented yet');
    }
}