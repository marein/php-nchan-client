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
    /**
     * @var Url
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
     *
     * @throws InvalidUrlException
     */
    public function __construct(string $baseUrl, Client $client = null)
    {
        $this->baseUrl = new Url($baseUrl);
        $this->client = $client ?? HttpStreamWrapperClient::withDefaults();
    }

    /**
     * Create the api for the given channel name.
     *
     * @param string $name
     *
     * @return Channel
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
     * Create the api for the given status path. The path must be configured with the "nchan_stub_status;" directive.
     *
     * @param string $path
     *
     * @return Status
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
