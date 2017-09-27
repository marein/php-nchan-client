<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

final class StatusInformation
{
    /**
     * @var array
     */
    private static $requiredFromPlainTextKeys = [
        'total published messages', 'stored messages', 'shared memory used', 'channels', 'subscribers',
        'redis pending commands', 'redis connected servers', 'total interprocess alerts received',
        'interprocess alerts in transit', 'interprocess queued alerts', 'total interprocess send delay',
        'total interprocess receive delay'
    ];

    /**
     * @var int
     */
    private $totalPublishedMessages;

    /**
     * @var int
     */
    private $storedMessages;

    /**
     * @var int
     */
    private $sharedMemoryUsed;

    /**
     * @var int
     */
    private $channels;

    /**
     * @var int
     */
    private $subscribers;

    /**
     * @var int
     */
    private $pendingRedisCommands;

    /**
     * @var int
     */
    private $connectedRedisServers;

    /**
     * @var int
     */
    private $totalReceivedInterprocessAlerts;

    /**
     * @var int
     */
    private $interprocessAlertsInTransit;

    /**
     * @var int
     */
    private $queuedInterprocessAlerts;

    /**
     * @var int
     */
    private $totalInterprocessSendDelay;

    /**
     * @var int
     */
    private $totalInterprocessReceiveDelay;

    /**
     * StatusInformation constructor.
     *
     * @param int $totalPublishedMessages
     * @param int $storedMessages
     * @param int $sharedMemoryUsed
     * @param int $channels
     * @param int $subscribers
     * @param int $pendingRedisCommands
     * @param int $connectedRedisServers
     * @param int $totalReceivedInterprocessAlerts
     * @param int $interprocessAlertsInTransit
     * @param int $queuedInterprocessAlerts
     * @param int $totalInterprocessSendDelay
     * @param int $totalInterprocessReceiveDelay
     */
    public function __construct(
        int $totalPublishedMessages,
        int $storedMessages,
        int $sharedMemoryUsed,
        int $channels,
        int $subscribers,
        int $pendingRedisCommands,
        int $connectedRedisServers,
        int $totalReceivedInterprocessAlerts,
        int $interprocessAlertsInTransit,
        int $queuedInterprocessAlerts,
        int $totalInterprocessSendDelay,
        int $totalInterprocessReceiveDelay
    ) {
        $this->totalPublishedMessages = $totalPublishedMessages;
        $this->storedMessages = $storedMessages;
        $this->sharedMemoryUsed = $sharedMemoryUsed;
        $this->channels = $channels;
        $this->subscribers = $subscribers;
        $this->pendingRedisCommands = $pendingRedisCommands;
        $this->connectedRedisServers = $connectedRedisServers;
        $this->totalReceivedInterprocessAlerts = $totalReceivedInterprocessAlerts;
        $this->interprocessAlertsInTransit = $interprocessAlertsInTransit;
        $this->queuedInterprocessAlerts = $queuedInterprocessAlerts;
        $this->totalInterprocessSendDelay = $totalInterprocessSendDelay;
        $this->totalInterprocessReceiveDelay = $totalInterprocessReceiveDelay;
    }

    /**
     * The plain text must look like this:
     *      total published messages: 3
     *      stored messages: 3
     *      shared memory used: 16K
     *      channels: 2
     *      subscribers: 2
     *      redis pending commands: 0
     *      redis connected servers: 2
     *      total interprocess alerts received: 0
     *      interprocess alerts in transit: 0
     *      interprocess queued alerts: 0
     *      total interprocess send delay: 0
     *      total interprocess receive delay: 0
     *
     * @param string $plainText
     *
     * @return StatusInformation
     * @throws NchanException
     */
    public static function fromPlainText(string $plainText): StatusInformation
    {
        $plainText = trim($plainText);
        $lines = explode("\n", $plainText);

        $response = [];
        foreach ($lines as $line) {
            list($key, $value) = explode(': ', $line);
            $response[$key] = $value;
        }

        // Check if required keys exists in $response.
        if (count(array_diff_key(array_flip(self::$requiredFromPlainTextKeys), $response)) !== 0) {
            throw new  NchanException(
                sprintf(
                    'Unable to parse status information: Keys "%s" are required. Keys "%s" exists.',
                    implode('", "', self::$requiredFromPlainTextKeys),
                    implode('", "', array_keys($response))
                )
            );
        }

        return new self(
            (int)$response['total published messages'],
            (int)$response['stored messages'],
            (int)$response['shared memory used'],
            (int)$response['channels'],
            (int)$response['subscribers'],
            (int)$response['redis pending commands'],
            (int)$response['redis connected servers'],
            (int)$response['total interprocess alerts received'],
            (int)$response['interprocess alerts in transit'],
            (int)$response['interprocess queued alerts'],
            (int)$response['total interprocess send delay'],
            (int)$response['total interprocess receive delay']
        );
    }

    /**
     * @return array
     */
    public static function requiredFromPlainTextKeys(): array
    {
        return self::$requiredFromPlainTextKeys;
    }

    /**
     * @return int
     */
    public function totalPublishedMessages(): int
    {
        return $this->totalPublishedMessages;
    }

    /**
     * @return int
     */
    public function storedMessages(): int
    {
        return $this->storedMessages;
    }

    /**
     * @return int
     */
    public function sharedMemoryUsed(): int
    {
        return $this->sharedMemoryUsed;
    }

    /**
     * @return int
     */
    public function channels(): int
    {
        return $this->channels;
    }

    /**
     * @return int
     */
    public function subscribers(): int
    {
        return $this->subscribers;
    }

    /**
     * @return int
     */
    public function pendingRedisCommands(): int
    {
        return $this->pendingRedisCommands;
    }

    /**
     * @return int
     */
    public function connectedRedisServers(): int
    {
        return $this->connectedRedisServers;
    }

    /**
     * @return int
     */
    public function totalReceivedInterprocessAlerts(): int
    {
        return $this->totalReceivedInterprocessAlerts;
    }

    /**
     * @return int
     */
    public function interprocessAlertsInTransit(): int
    {
        return $this->interprocessAlertsInTransit;
    }

    /**
     * @return int
     */
    public function queuedInterprocessAlerts(): int
    {
        return $this->queuedInterprocessAlerts;
    }

    /**
     * @return int
     */
    public function totalInterprocessSendDelay(): int
    {
        return $this->totalInterprocessSendDelay;
    }

    /**
     * @return int
     */
    public function totalInterprocessReceiveDelay(): int
    {
        return $this->totalInterprocessReceiveDelay;
    }
}