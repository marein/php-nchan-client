<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

/**
 * Represents the data structure for the channel api.
 *
 * @property-read int $numberOfMessages
 * Number of current messages in this channel.
 *
 * @property-read int $secondsSinceLastPublishedMessage
 * Seconds since the last message was published.
 *
 * @property-read int $numberOfSubscribers
 * Number of current subscribers in this channel.
 *
 * @property-read int $lastMessageIdentifier
 * Last published message identifier.
 */
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
    private $numberOfSubscribers;

    /**
     * @var string
     */
    private $lastMessageIdentifier;

    /**
     * ChannelInformation constructor.
     *
     * @param int    $numberOfMessages
     * @param int    $secondsSinceLastPublishedMessage
     * @param int    $numberOfSubscribers
     * @param string $lastMessageIdentifier
     */
    private function __construct(
        int $numberOfMessages,
        int $secondsSinceLastPublishedMessage,
        int $numberOfSubscribers,
        string $lastMessageIdentifier
    ) {
        $this->numberOfMessages = $numberOfMessages;
        $this->secondsSinceLastPublishedMessage = $secondsSinceLastPublishedMessage;
        $this->numberOfSubscribers = $numberOfSubscribers;
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
     * Returns the value of the given variable.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }
}
