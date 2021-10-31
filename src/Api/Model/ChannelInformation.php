<?php

declare(strict_types=1);

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

/**
 * @property-read int $numberOfMessages
 *
 * @property-read int $secondsSinceLastPublishedMessage
 *
 * @property-read int $numberOfSubscribers
 *
 * @property-read string $lastMessageIdentifier
 */
final class ChannelInformation
{
    /**
     * @var string[]
     */
    private const REQUIRED_JSON_KEYS = [
        'messages',
        'requested',
        'subscribers',
        'last_message_id'
    ];

    private int $numberOfMessages;

    private int $secondsSinceLastPublishedMessage;

    private int $numberOfSubscribers;

    private string $lastMessageIdentifier;

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
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }
}
