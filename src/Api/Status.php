<?php
declare(strict_types=1);

namespace Marein\Nchan\Api;

use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\ThrowExceptionIfRequestRequiresAuthenticationClient;
use Marein\Nchan\Http\Url;
use Marein\Nchan\Api\Model\StatusInformation;

final class Status
{
    /**
     * @var Url
     */
    private Url $statusUrl;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * Status constructor.
     *
     * @param Url    $statusUrl
     * @param Client $client
     */
    public function __construct(Url $statusUrl, Client $client)
    {
        $this->statusUrl = $statusUrl;
        $this->client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $client
        );
    }

    /**
     * Returns the current nchan status.
     *
     * @return StatusInformation
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
