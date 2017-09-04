<?php

namespace Marein\Nchan\Http\Adapter;

use Marein\Nchan\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues()
    {
        $expectedName = 'my-message-name';
        $expectedPayload = 'my message payload';

        $message = new Message($expectedName, $expectedPayload);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedPayload, $message->payload());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyName()
    {
        $expectedName = '';
        $expectedPayload = 'my message payload';

        $message = new Message($expectedName, $expectedPayload);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedPayload, $message->payload());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyPayload()
    {
        $expectedName = 'my-message-name';
        $expectedPayload = '';

        $message = new Message($expectedName, $expectedPayload);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedPayload, $message->payload());
    }
}