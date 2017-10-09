<?php

namespace Marein\Nchan\Api\Model;

use Marein\Nchan\Exception\NchanException;
use PHPUnit\Framework\TestCase;

class ChannelInformationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
    {
        $channelInformation = new ChannelInformation(
            10,
            1,
            100,
            '1504818382:1'
        );

        $this->assertSame(10, $channelInformation->numberOfMessages());
        $this->assertSame(1, $channelInformation->secondsSinceLastPublishedMessage());
        $this->assertSame(100, $channelInformation->numberOfCurrentSubscribers());
        $this->assertSame('1504818382:1', $channelInformation->lastMessageIdentifier());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedFromValidJson(): void
    {
        $json = $this->validJson();

        $channelInformation = ChannelInformation::fromJson($json);

        $this->assertSame(10, $channelInformation->numberOfMessages());
        $this->assertSame(1, $channelInformation->secondsSinceLastPublishedMessage());
        $this->assertSame(100, $channelInformation->numberOfCurrentSubscribers());
        $this->assertSame('1504818382:1', $channelInformation->lastMessageIdentifier());
    }

    /**
     * @test
     */
    public function itShouldBeThrowAnExceptionWhenJsonIsInvalid(): void
    {
        $this->expectException(NchanException::class);

        $json = 'malformed json"}';

        ChannelInformation::fromJson($json);
    }

    /**
     * @test
     * @dataProvider missingKeysProvider
     */
    public function itShouldBeThrowAnExceptionWhenJsonHasMissingKeys(string $json): void
    {
        $this->expectException(NchanException::class);

        ChannelInformation::fromJson($json);
    }

    /**
     * Returns various json with missing keys.
     *
     * @return array
     */
    public function missingKeysProvider(): array
    {
        return [
            ['{"requested": 1, "subscribers": 100, "last_message_id": "1504818382:1"}'],
            ['{"messages": 10, "subscribers": 100, "last_message_id": "1504818382:1"}'],
            ['{"messages": 10, "requested": 1, "last_message_id": "1504818382:1"}'],
            ['{"messages": 10, "requested": 1, "subscribers": 100}']
        ];
    }

    /**
     * Returns a valid json for tests.
     *
     * @return string
     */
    private function validJson(): string
    {
        return '{"messages": 10, "requested": 1, "subscribers": 100, "last_message_id": "1504818382:1"}';
    }
}
