<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

final class ChannelInformation
{
    /**
     * @var int
     */
    private $numberOfMessages;

    /**
     * @var int
     */
    private $secondsUntilLastRequested;

    /**
     * @var int
     */
    private $numberOfCurrentSubscribers;

    /**
     * @var string
     */
    private $lastMessageIdentifier;

    /**
     * ChannelInformation constructor.
     *
     * @param int    $numberOfMessages
     * @param int    $secondsUntilLastRequested
     * @param int    $numberOfCurrentSubscribers
     * @param string $lastMessageIdentifier
     */
    public function __construct(
        int $numberOfMessages,
        int $secondsUntilLastRequested,
        int $numberOfCurrentSubscribers,
        string $lastMessageIdentifier
    ) {
        $this->numberOfMessages = $numberOfMessages;
        $this->secondsUntilLastRequested = $secondsUntilLastRequested;
        $this->numberOfCurrentSubscribers = $numberOfCurrentSubscribers;
        $this->lastMessageIdentifier = $lastMessageIdentifier;
    }

    /**
     * @param string $json
     *
     * @return ChannelInformation
     * @throws NchanException
     */
    public static function fromJson(string $json): ChannelInformation
    {
        $response = json_decode($json);

        if ($response === null) {
            throw new NchanException('Unable to parse JSON response');
        }

        return new self(
            (int)$response->messages,
            (int)$response->requested,
            (int)$response->subscribers,
            (string)$response->last_message_id
        );
    }

    /**
     * @return int
     */
    public function numberOfMessages(): int
    {
        return $this->numberOfMessages;
    }

    /**
     * @return int
     */
    public function secondsUntilLastRequested(): int
    {
        return $this->secondsUntilLastRequested;
    }

    /**
     * @return int
     */
    public function numberOfCurrentSubscribers(): int
    {
        return $this->numberOfCurrentSubscribers;
    }

    /**
     * @return string
     */
    public function lastMessageIdentifier(): string
    {
        return $this->lastMessageIdentifier;
    }
}