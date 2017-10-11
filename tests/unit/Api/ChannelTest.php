<?php

namespace Marein\Nchan\Api;

use Marein\Nchan\Api\Model\ChannelInformation;
use Marein\Nchan\Api\Model\Message;
use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\Url;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldPublishMessage(): void
    {
        // 201 and 202 are valid status codes
        foreach ([201, 202] as $statusCode) {
            $expectedRequest = new Request(
                new Url('http://localhost'),
                [
                    'Content-Type' => 'text/plain',
                    'Accept' => 'application/json',
                    'X-EventSource-Event' => 'my-message-name'
                ],
                'my message content'
            );

            $response = $this->createMock(Response::class);
            $response->method('body')->willReturn(
                '{"messages": 10, "requested": 1, "subscribers": 100, "last_message_id": "1504818382:1"}'
            );
            $response->method('statusCode')->willReturn($statusCode);

            $client = $this->createMock(Client::class);
            $client->method('post')->with($expectedRequest)->willReturn($response);

            $message = $this->createMock(Message::class);
            $message->method('contentType')->willReturn('text/plain');
            $message->method('name')->willReturn('my-message-name');
            $message->method('content')->willReturn('my message content');

            $channel = new Channel(new Url('http://localhost'), $client);
            $information = $channel->publish($message);

            $this->assertInstanceOf(ChannelInformation::class, $information);
        }
    }

    /**
     * @test
     */
    public function itShouldReturnInformation(): void
    {
        $expectedRequest = new Request(
            new Url('http://localhost'),
            [
                'Accept' => 'application/json',
            ]
        );

        $response = $this->createMock(Response::class);
        $response->method('body')->willReturn(
            '{"messages": 10, "requested": 1, "subscribers": 100, "last_message_id": "1504818382:1"}'
        );
        $response->method('statusCode')->willReturn(200);

        $client = $this->createMock(Client::class);
        $client->method('get')->with($expectedRequest)->willReturn($response);

        $channel = new Channel(new Url('http://localhost'), $client);
        $information = $channel->information();

        $this->assertInstanceOf(ChannelInformation::class, $information);
    }

    /**
     * @test
     */
    public function itShouldDeleteChannel(): void
    {
        // 200 and 404 are valid status codes
        foreach ([200, 404] as $statusCode) {
            $expectedRequest = new Request(
                new Url('http://localhost'),
                [
                    'Accept' => 'application/json',
                ]
            );

            $response = $this->createMock(Response::class);
            $response->method('statusCode')->willReturn($statusCode);

            $client = $this->createMock(Client::class);
            $client->method('delete')->with($expectedRequest)->willReturn($response);

            $channel = new Channel(new Url('http://localhost'), $client);
            $channel->delete();

            // Test passed
            $this->assertTrue(true);
        }
    }

    /**
     * @test
     */
    public function publishShouldThrowExceptionOnNotExpectedStatusCode()
    {
        $this->expectException(NchanException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(302);

        $client = $this->createMock(Client::class);
        $client->method('post')->willReturn($response);

        $message = $this->createMock(Message::class);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->publish($message);
    }

    /**
     * @test
     */
    public function informationShouldThrowExceptionOnNotExpectedStatusCode()
    {
        $this->expectException(NchanException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(302);

        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->information();
    }

    /**
     * @test
     */
    public function deleteShouldThrowExceptionOnNotExpectedStatusCode()
    {
        $this->expectException(NchanException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(302);

        $client = $this->createMock(Client::class);
        $client->method('delete')->willReturn($response);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->delete();
    }

    /**
     * @test
     */
    public function publishShouldThrowExceptionIfForbidden()
    {
        $this->expectException(AuthenticationRequiredException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(403);

        $client = $this->createMock(Client::class);
        $client->method('post')->willReturn($response);

        $message = $this->createMock(Message::class);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->publish($message);
    }

    /**
     * @test
     */
    public function informationShouldThrowExceptionIfForbidden()
    {
        $this->expectException(AuthenticationRequiredException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(403);

        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->information();
    }

    /**
     * @test
     */
    public function deleteShouldThrowExceptionIfForbidden()
    {
        $this->expectException(AuthenticationRequiredException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(403);

        $client = $this->createMock(Client::class);
        $client->method('delete')->willReturn($response);

        $channel = new Channel(new Url('http://localhost'), $client);
        $channel->delete();
    }
}
