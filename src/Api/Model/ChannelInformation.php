<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

final class ChannelInformation
{
    /**
     * @var array
     */
    private const REQUIRED_JSON_KEYS = [
        'messages',
        'requested',
        'subscribers',
        'last_message_id'
    ];

    /**
     * @var int
     */
    private $numberOfMessages;

    /**
     * @var int
     */
    private $secondsSinceLastPublishedMessage;

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
     * @param int    $secondsSinceLastPublishedMessage
     * @param int    $numberOfCurrentSubscribers
     * @param string $lastMessageIdentifier
     */
    public function __construct(
        int $numberOfMessages,
        int $secondsSinceLastPublishedMessage,
        int $numberOfCurrentSubscribers,
        string $lastMessageIdentifier
    ) {
        $this->numberOfMessages = $numberOfMessages;
        $this->secondsSinceLastPublishedMessage = $secondsSinceLastPublishedMessage;
        $this->numberOfCurrentSubscribers = $numberOfCurrentSubscribers;
        $this->lastMessageIdentifier = $lastMessageIdentifier;
    }

    /**
     * The json must look like this:
     *      {
     *          "messages": 10,
     *          "requested": 1,
     *          "subscribers": 100,
     *          "last_message_id": "1504818382:1"
     *      }
     *
     * @param string $json
     *
     * @return ChannelInformation
     * @throws NchanException
     */
    public static function fromJson(string $json): ChannelInformation
    {
        $response = json_decode($json, true);

        if (!is_array($response)) {
            throw new NchanException('Unable to parse JSON response: ' . json_last_error_msg());
        }

        // Check if required keys exists in $response.
        if (count(array_diff_key(array_flip(self::REQUIRED_JSON_KEYS), $response)) !== 0) {
            throw new  NchanException(
                sprintf(
                    'Unable to parse JSON response: Keys "%s" are required. Keys "%s" exists.',
                    implode('", "', self::REQUIRED_JSON_KEYS),
                    implode('", "', array_keys($response))
                )
            );
        }

        return new self(
            (int)$response['messages'],
            (int)$response['requested'],
            (int)$response['subscribers'],
            (string)$response['last_message_id']
        );
    }

    /**
     * Number of current messages in this channel.
     *
     * @return int
     */
    public function numberOfMessages(): int
    {
        return $this->numberOfMessages;
    }

    /**
     * Seconds since the last message was published.
     *
     * @return int
     */
    public function secondsSinceLastPublishedMessage(): int
    {
        return $this->secondsSinceLastPublishedMessage;
    }

    /**
     * Number of current subscribers in this channel.
     *
     * @return int
     */
    public function numberOfCurrentSubscribers(): int
    {
        return $this->numberOfCurrentSubscribers;
    }

    /**
     * Last published message identifier.
     *
     * @return string
     */
    public function lastMessageIdentifier(): string
    {
        return $this->lastMessageIdentifier;
    }
}
