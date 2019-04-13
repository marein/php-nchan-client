<?php
declare(strict_types=1);

namespace Marein\Nchan\Tests\Unit\Api\Model;

use Marein\Nchan\Api\Model\JsonMessage;
use PHPUnit\Framework\TestCase;

class JsonMessageTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
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
    public function itShouldBeCreatedWithEmptyName(): void
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
    public function itShouldBeCreatedWithEmptyContent(): void
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
