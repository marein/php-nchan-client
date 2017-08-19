<?php

namespace Marein\Nchan\Api;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\Url;
use Marein\Nchan\StatusInformation;

final class Status
{
    /**
     * @var Url
     */
    private $statusUrl;

    /**
     * @var Client
     */
    private $client;

    /**
     * Status constructor.
     *
     * @param Url    $statusUrl
     * @param Client $client
     */
    public function __construct(Url $statusUrl, Client $client)
    {
        $this->statusUrl = $statusUrl;
        $this->client = $client;
    }

    /**
     * @return StatusInformation
     * @throws NchanException
     */
    public function information(): StatusInformation
    {
        $response = $this->client->get(new Request(
            $this->statusUrl,
            [
                'Accept' => 'text/plain'
            ]
        ));

        if ($response->statusCode() === Response::OK) {
            return StatusInformation::fromPlainText($response->body());
        }

        throw new NchanException('Unable to retrieve status information.');
    }
}