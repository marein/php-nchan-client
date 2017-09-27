<?php

namespace Marein\Nchan;

use Marein\Nchan\Api\Channel;
use Marein\Nchan\Api\Status;
use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;
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
        $this->client = $client ?? new HttpStreamWrapperClient();
    }

    /**
     * Create the api for the given channel name.
     *
     * @param string $name
     *
     * @return Channel
     */
    public function channel(string $name): Channel
    {
        return new Channel($this->baseUrl->append($name), $this->client);
    }

    /**
     * Create the api for the given status path. The path must be configured with the "nchan_stub_status;" directive.
     *
     * @param string $path
     *
     * @return Status
     */
    public function status(string $path): Status
    {
        return new Status($this->baseUrl->append($path), $this->client);
    }

    /**
     * Create the api for the given group name.
     *
     * @param string $name
     *
     * @throws \Exception
     */
    public function group(string $name): void
    {
        throw new \Exception('Not implemented yet');
    }
}