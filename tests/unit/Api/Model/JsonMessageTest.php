<?php

namespace Marein\Nchan\Api\Model;

use PHPUnit\Framework\TestCase;

class JsonMessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues()
    {
        $expectedName = 'my-message-name';
        $expectedContent = 'my message content';
        $expectedContentType = 'application/json';

        $message = new JsonMessage($expectedName, $expectedContent);

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
        $expectedContentType = 'application/json';

        $message = new JsonMessage($expectedName, $expectedContent);

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
        $expectedContentType = 'application/json';

        $message = new JsonMessage($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
        $this->assertEquals($expectedContentType, $message->contentType());
    }
}