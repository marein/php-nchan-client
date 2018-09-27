<?php
declare(strict_types=1);

namespace Marein\Nchan\Api;

use Marein\Nchan\Api\Model\ChannelInformation;
use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\ThrowExceptionIfRequestRequiresAuthenticationClient;
use Marein\Nchan\Http\Url;
use Marein\Nchan\Api\Model\Message;

final class Channel
{
    /**
     * @var Url
     */
    private $channelUrl;

    /**
     * @var Client
     */
    private $client;

    /**
     * Channel constructor.
     *
     * @param Url    $channelUrl
     * @param Client $client
     */
    public function __construct(Url $channelUrl, Client $client)
    {
        $this->channelUrl = $channelUrl;
        $this->client = new ThrowExceptionIfRequestRequiresAuthenticationClient($client);
    }

    /**
     * Publish a message to this channel.
     *
     * @param Message $message
     *
     * @return ChannelInformation
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function publish(Message $message): ChannelInformation
    {
        $response = $this->client->post(new Request(
            $this->channelUrl,
            [
                'Accept'              => 'application/json',
                'Content-Type'        => $message->contentType(),
                'X-EventSource-Event' => $message->name()
            ],
            $message->content()
        ));

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
     * Returns the information from this channel.
     *
     * @return ChannelInformation
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function information(): ChannelInformation
    {
        $response = $this->client->get(new Request(
            $this->channelUrl,
            [
                'Accept' => 'application/json'
            ]
        ));

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
     * Delete this channel.
     *
     * @throws AuthenticationRequiredException
     * @throws NchanException
     */
    public function delete(): void
    {
        $response = $this->client->delete(new Request(
            $this->channelUrl,
            [
                'Accept' => 'application/json'
            ]
        ));

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
