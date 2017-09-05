<?php

namespace Marein\Nchan\Api\Model;

use PHPUnit\Framework\TestCase;

class XmlMessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues()
    {
        $expectedName = 'my-message-name';
        $expectedContent = 'my message content';
        $expectedContentType = 'application/xml';

        $message = new XmlMessage($expectedName, $expectedContent);

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
        $expectedContentType = 'application/xml';

        $message = new XmlMessage($expectedName, $expectedContent);

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
        $expectedContentType = 'application/xml';

        $message = new XmlMessage($expectedName, $expectedContent);

        $this->assertEquals($expectedName, $message->name());
        $this->assertEquals($expectedContent, $message->content());
        $this->assertEquals($expectedContentType, $message->contentType());
    }
}