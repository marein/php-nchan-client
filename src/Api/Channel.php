<?php

declare(strict_types=1);

namespace Marein\Nchan\Api;

use Marein\Nchan\Api\Model\ChannelInformation;
use Marein\Nchan\Api\Model\Message;
use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\ThrowExceptionIfRequestRequiresAuthenticationClient;
use Marein\Nchan\Http\Url;

final class Channel
{
    private Url $channelUrl;

    private Client $client;

    public function __construct(Url $channelUrl, Client $client)
    {
        $this->channelUrl = $channelUrl;
        $this->client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $client
        );
    }

    /**
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function publish(Message $message): ChannelInformation
    {
        $response = $this->client->post(
            new Request(
                $this->channelUrl,
                [
                    'Accept' => 'application/json',
                    'Content-Type' => $message->contentType(),
                    'X-EventSource-Event' => $message->name()
                ],
                $message->content()
            )
        );

        if (!in_array($response->statusCode(), [Response::CREATED, Response::ACCEPTED])) {
            throw new NchanException(
                sprintf(
                    'Unable to publish to channel. Maybe the channel does not exists. HTTP status code was %s.',
                    $response->statusCode()
                )
            );
        }

        return ChannelInformation::fromJson($response->body());
    }

    /**
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function information(): ChannelInformation
    {
        $response = $this->client->get(
            new Request(
                $this->channelUrl,
                [
                    'Accept' => 'application/json'
                ]
            )
        );

        if ($response->statusCode() !== Response::OK) {
            throw new NchanException(
                sprintf(
                    'Unable to get channel information. Maybe the channel does not exists. HTTP status code was %s.',
                    $response->statusCode()
                )
            );
        }

        return ChannelInformation::fromJson($response->body());
    }

    /**
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function delete(): void
    {
        $response = $this->client->delete(
            new Request(
                $this->channelUrl,
                [
                    'Accept' => 'application/json'
                ]
            )
        );

        if (!in_array($response->statusCode(), [Response::OK, RESPONSE::NOT_FOUND])) {
            throw new NchanException(
                sprintf(
                    'Unable to delete channel. Maybe the channel does not exists. HTTP status code was %s.',
                    $response->statusCode()
                )
            );
        }
    }
}
