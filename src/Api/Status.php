<?php

declare(strict_types=1);

namespace Marein\Nchan\Api;

use Marein\Nchan\Api\Model\StatusInformation;
use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\ThrowExceptionIfRequestRequiresAuthenticationClient;
use Marein\Nchan\Http\Url;

final class Status
{
    private Url $statusUrl;

    private Client $client;

    public function __construct(Url $statusUrl, Client $client)
    {
        $this->statusUrl = $statusUrl;
        $this->client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $client
        );
    }

    /**
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function information(): StatusInformation
    {
        $response = $this->client->get(
            new Request(
                $this->statusUrl,
                [
                    'Accept' => 'text/plain'
                ]
            )
        );

        if ($response->statusCode() !== Response::OK) {
            throw new NchanException(
                sprintf(
                    'Unable to retrieve status information. HTTP status code was %s.',
                    $response->statusCode()
                )
            );
        }

        return StatusInformation::fromPlainText($response->body());
    }
}
