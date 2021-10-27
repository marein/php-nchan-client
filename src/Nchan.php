<?php

declare(strict_types=1);

namespace Marein\Nchan;

use Marein\Nchan\Api\Channel;
use Marein\Nchan\Api\Status;
use Marein\Nchan\Exception\InvalidUrlException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Url;
use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;

final class Nchan
{
    private Url $baseUrl;

    private Client $client;

    /**
     * @throws InvalidUrlException
     */
    public function __construct(string $baseUrl, ?Client $client = null)
    {
        $this->baseUrl = new Url($baseUrl);
        $this->client = $client ?? HttpStreamWrapperClient::withDefaults();
    }

    /**
     * @throws InvalidUrlException
     */
    public function channel(string $name): Channel
    {
        return new Channel(
            $this->baseUrl->append($name),
            $this->client
        );
    }

    /**
     * The path must be configured with the "nchan_stub_status;" directive.
     *
     * @throws InvalidUrlException
     */
    public function status(string $path): Status
    {
        return new Status(
            $this->baseUrl->append($path),
            $this->client
        );
    }
}
