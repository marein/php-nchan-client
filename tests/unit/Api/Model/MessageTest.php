<?php

namespace Marein\Nchan\Api\Model;

use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues()
    {
        $expectedName = 'my-message-name';
        $expectedPayload = 'my message content';

        $message = new Message($expectedName, $expectedPayload);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedPayload, $message->content());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyName()
    {
        $expectedName = '';
        $expectedPayload = 'my message content';

        $message = new Message($expectedName, $expectedPayload);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedPayload, $message->content());
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
        $this->assertEquals($expectedPayload, $message->content());
    }
}