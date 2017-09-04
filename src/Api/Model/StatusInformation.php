<?php

namespace Marein\Nchan\Api\Model;

final class StatusInformation
{
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
    private $interprocessQueuedAlerts;

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
     * @param int $interprocessQueuedAlerts
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
        int $interprocessQueuedAlerts,
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
        $this->interprocessQueuedAlerts = $interprocessQueuedAlerts;
        $this->totalInterprocessSendDelay = $totalInterprocessSendDelay;
        $this->totalInterprocessReceiveDelay = $totalInterprocessReceiveDelay;
    }

    /**
     * The plain text should look like this:
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
     */
    public static function fromPlainText(string $plainText): StatusInformation
    {
        $parts = explode("\n", $plainText);

        $getValue = function (int $index) use ($parts) {
            $value = $parts[$index];

            return substr($value, strpos($value, ': ') + 2);
        };

        return new self(
            (int)$getValue(0),
            (int)$getValue(1),
            (int)$getValue(2),
            (int)$getValue(3),
            (int)$getValue(4),
            (int)$getValue(5),
            (int)$getValue(6),
            (int)$getValue(7),
            (int)$getValue(8),
            (int)$getValue(9),
            (int)$getValue(10),
            (int)$getValue(11)
        );
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
    public function interprocessQueuedAlerts(): int
    {
        return $this->interprocessQueuedAlerts;
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