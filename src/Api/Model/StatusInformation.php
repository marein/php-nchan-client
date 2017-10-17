<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;

/**
 * Represents the data structure for the status api.
 *
 * @property-read int $numberOfTotalPublishedMessages
 * Number of messages published to all channels through this Nchan server.
 *
 * @property-read int $numberOfStoredMessages
 * Number of messages currently buffered in memory.
 *
 * @property-read int $sharedMemoryUsedInKilobyte
 * Total shared memory used for buffering messages, storing channel information, and other purposes.
 * This value should be comfortably below nchan_shared_memory_size.
 *
 * @property-read int $numberOfChannels
 * Number of channels present on this Nchan server.
 *
 * @property-read int $numberOfSubscribers
 * Number of subscribers to all channels on this Nchan server.
 *
 * @property-read int $numberOfPendingRedisCommands
 * Number of commands sent to Redis that are awaiting a reply.
 * May spike during high load, especially if the Redis server is overloaded. Should tend towards 0.
 *
 * @property-read int $numberOfConnectedRedisServers
 * Number of redis servers to which Nchan is currently connected.
 *
 * @property-read int $numberOfTotalReceivedInterprocessAlerts
 * Number of interprocess communication packets transmitted between Nginx workers processes for Nchan.
 * Can grow at 100-10000 per second at high load.
 *
 * @property-read int $numberOfInterprocessAlertsInTransit
 * Number of interprocess communication packets in transit between Nginx workers.
 * May be nonzero during high load, but should always tend toward 0 over time.
 *
 * @property-read int $numberOfQueuedInterprocessAlerts
 * Number of interprocess communication packets waiting to be sent.
 * May be nonzero during high load, but should always tend toward 0 over time.
 *
 * @property-read int $numberOfTotalInterprocessSendDelay
 * Total amount of time interprocess communication packets spend being queued if delayed.
 * May increase during high load.
 *
 * @property-read int $numberOfTotalInterprocessReceiveDelay
 * Total amount of time interprocess communication packets spend in transit if delayed.
 * May increase during high load.
 */
final class StatusInformation
{
    /**
     * @var array
     */
    private const REQUIRED_PLAIN_TEXT_KEYS = [
        'total published messages',
        'stored messages',
        'shared memory used',
        'channels',
        'subscribers',
        'redis pending commands',
        'redis connected servers',
        'total interprocess alerts received',
        'interprocess alerts in transit',
        'interprocess queued alerts',
        'total interprocess send delay',
        'total interprocess receive delay'
    ];

    /**
     * @var int
     */
    private $numberOfTotalPublishedMessages;

    /**
     * @var int
     */
    private $numberOfStoredMessages;

    /**
     * @var int
     */
    private $sharedMemoryUsedInKilobyte;

    /**
     * @var int
     */
    private $numberOfChannels;

    /**
     * @var int
     */
    private $numberOfSubscribers;

    /**
     * @var int
     */
    private $numberOfPendingRedisCommands;

    /**
     * @var int
     */
    private $numberOfConnectedRedisServers;

    /**
     * @var int
     */
    private $numberOfTotalReceivedInterprocessAlerts;

    /**
     * @var int
     */
    private $numberOfInterprocessAlertsInTransit;

    /**
     * @var int
     */
    private $numberOfQueuedInterprocessAlerts;

    /**
     * @var int
     */
    private $numberOfTotalInterprocessSendDelay;

    /**
     * @var int
     */
    private $numberOfTotalInterprocessReceiveDelay;

    /**
     * StatusInformation constructor.
     *
     * @param int $numberOfTotalPublishedMessages
     * @param int $numberOfStoredMessages
     * @param int $sharedMemoryUsedInKilobyte
     * @param int $numberOfChannels
     * @param int $numberOfSubscribers
     * @param int $numberOfPendingRedisCommands
     * @param int $numberOfConnectedRedisServers
     * @param int $numberOfTotalReceivedInterprocessAlerts
     * @param int $numberOfInterprocessAlertsInTransit
     * @param int $numberOfQueuedInterprocessAlerts
     * @param int $numberOfTotalInterprocessSendDelay
     * @param int $numberOfTotalInterprocessReceiveDelay
     */
    private function __construct(
        int $numberOfTotalPublishedMessages,
        int $numberOfStoredMessages,
        int $sharedMemoryUsedInKilobyte,
        int $numberOfChannels,
        int $numberOfSubscribers,
        int $numberOfPendingRedisCommands,
        int $numberOfConnectedRedisServers,
        int $numberOfTotalReceivedInterprocessAlerts,
        int $numberOfInterprocessAlertsInTransit,
        int $numberOfQueuedInterprocessAlerts,
        int $numberOfTotalInterprocessSendDelay,
        int $numberOfTotalInterprocessReceiveDelay
    )
    {
        $this->numberOfTotalPublishedMessages = $numberOfTotalPublishedMessages;
        $this->numberOfStoredMessages = $numberOfStoredMessages;
        $this->sharedMemoryUsedInKilobyte = $sharedMemoryUsedInKilobyte;
        $this->numberOfChannels = $numberOfChannels;
        $this->numberOfSubscribers = $numberOfSubscribers;
        $this->numberOfPendingRedisCommands = $numberOfPendingRedisCommands;
        $this->numberOfConnectedRedisServers = $numberOfConnectedRedisServers;
        $this->numberOfTotalReceivedInterprocessAlerts = $numberOfTotalReceivedInterprocessAlerts;
        $this->numberOfInterprocessAlertsInTransit = $numberOfInterprocessAlertsInTransit;
        $this->numberOfQueuedInterprocessAlerts = $numberOfQueuedInterprocessAlerts;
        $this->numberOfTotalInterprocessSendDelay = $numberOfTotalInterprocessSendDelay;
        $this->numberOfTotalInterprocessReceiveDelay = $numberOfTotalInterprocessReceiveDelay;
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
            // Appending ': ' prevents error if no ': ' exists.
            [$key, $value] = explode(': ', trim($line) . ': ');
            $response[$key] = $value;
        }

        // Check if required keys exists in $response.
        if (count(array_diff_key(array_flip(self::REQUIRED_PLAIN_TEXT_KEYS), $response)) !== 0) {
            throw new  NchanException(
                sprintf(
                    'Unable to parse status information: Keys "%s" are required. Keys "%s" exists.',
                    implode('", "', self::REQUIRED_PLAIN_TEXT_KEYS),
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
