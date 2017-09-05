<?php

namespace Marein\Nchan\Api\Model;

use PHPUnit\Framework\TestCase;

class PlainTextMessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues()
    {
        $expectedName = 'my-message-name';
        $expectedContent = 'my message content';
        $expectedContentType = 'text/plain';

        $message = new PlainTextMessage($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
        $this->assertEquals($expectedContentType, $message->contentType());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyName()
    {
        $expectedName = '';
        $expectedContent = 'my message content';
        $expectedContentType = 'text/plain';

        $message = new PlainTextMessage($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
        $this->assertEquals($expectedContentType, $message->contentType());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithEmptyContent()
    {
        $expectedName = 'my-message-name';
        $expectedContent = '';
        $expectedContentType = 'text/plain';

        $message = new PlainTextMessage($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
        $this->assertEquals($expectedContentType, $message->contentType());
    }
}