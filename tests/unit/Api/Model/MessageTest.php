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
        $expectedContent = 'my message content';

        $message = new Message($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyName()
    {
        $expectedName = '';
        $expectedContent = 'my message content';

        $message = new Message($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyContent()
    {
        $expectedName = 'my-message-name';
        $expectedContent = '';

        $message = new Message($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
    }
}