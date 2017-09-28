<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;
use PHPUnit\Framework\TestCase;

class StatusInformationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
    {
        $statusInformation = new StatusInformation(
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

        $this->assertSame(1, $statusInformation->totalPublishedMessages());
        $this->assertSame(2, $statusInformation->storedMessages());
        $this->assertSame(3, $statusInformation->sharedMemoryUsed());
        $this->assertSame(4, $statusInformation->channels());
        $this->assertSame(5, $statusInformation->subscribers());
        $this->assertSame(6, $statusInformation->pendingRedisCommands());
        $this->assertSame(7, $statusInformation->connectedRedisServers());
        $this->assertSame(8, $statusInformation->totalReceivedInterprocessAlerts());
        $this->assertSame(9, $statusInformation->interprocessAlertsInTransit());
        $this->assertSame(10, $statusInformation->queuedInterprocessAlerts());
        $this->assertSame(11, $statusInformation->totalInterprocessSendDelay());
        $this->assertSame(12, $statusInformation->totalInterprocessReceiveDelay());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedFromValidPlainText(): void
    {
        $plainText = $this->validPlainText();

        $statusInformation = StatusInformation::fromPlainText($plainText);

        $this->assertSame(1, $statusInformation->totalPublishedMessages());
        $this->assertSame(2, $statusInformation->storedMessages());
        $this->assertSame(3, $statusInformation->sharedMemoryUsed());
        $this->assertSame(4, $statusInformation->channels());
        $this->assertSame(5, $statusInformation->subscribers());
        $this->assertSame(6, $statusInformation->pendingRedisCommands());
        $this->assertSame(7, $statusInformation->connectedRedisServers());
        $this->assertSame(8, $statusInformation->totalReceivedInterprocessAlerts());
        $this->assertSame(9, $statusInformation->interprocessAlertsInTransit());
        $this->assertSame(10, $statusInformation->queuedInterprocessAlerts());
        $this->assertSame(11, $statusInformation->totalInterprocessSendDelay());
        $this->assertSame(12, $statusInformation->totalInterprocessReceiveDelay());
    }

    /**
     * @test
     */
    public function itShouldBeThrowAnExceptionWhenPlainTextIsInvalid(): void
    {
        $this->expectException(NchanException::class);

        $plainText = 'malformed plain text';

        StatusInformation::fromPlainText($plainText);
    }

    /**
     * @test
     * @dataProvider missingKeysProvider
     */
    public function itShouldBeThrowAnExceptionWhenPlainTextHasMissingKeys(string $plainText): void
    {
        $this->expectException(NchanException::class);

        StatusInformation::fromPlainText($plainText);
    }

    /**
     * Returns various plain text with missing keys.
     *
     * @return array
     */
    public function missingKeysProvider(): array
    {
        return [
            [
                '
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    total interprocess send delay: 11
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess receive delay: 12
                '
            ],
            [
                '
                    total published messages: 1
                    stored messages: 2
                    shared memory used: 3K
                    channels: 4
                    subscribers: 5
                    redis pending commands: 6
                    redis connected servers: 7
                    total interprocess alerts received: 8
                    interprocess alerts in transit: 9
                    interprocess queued alerts: 10
                    total interprocess send delay: 11
                '
            ]
        ];
    }

    /**
     * Returns a valid plain text for tests.
     *
     * @return string
     */
    private function validPlainText(): string
    {
        return <<< STRING
total published messages: 1
stored messages: 2
shared memory used: 3K
channels: 4
subscribers: 5
redis pending commands: 6
redis connected servers: 7
total interprocess alerts received: 8
interprocess alerts in transit: 9
interprocess queued alerts: 10
total interprocess send delay: 11
total interprocess receive delay: 12
STRING;
    }
}