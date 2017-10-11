<?php

namespace Marein\Nchan\Api;

use Marein\Nchan\Api\Model\StatusInformation;
use Marein\Nchan\Exception\AuthenticationRequiredException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\Url;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnInformation(): void
    {
        $response = $this->createMock(Response::class);
        $response->method('body')->willReturn(<<< STRING
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
STRING
        );
        $response->method('statusCode')->willReturn(200);

        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);

        $status = new Status(new Url('http://localhost'), $client);
        $information = $status->information();

        $this->assertInstanceOf(StatusInformation::class, $information);
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

        $status = new Status(new Url('http://localhost'), $client);
        $status->information();
    }

    /**
     * @test
     */
    public function informationShouldThrowExceptionOnNotExpectedStatusCode()
    {
        $this->expectException(NchanException::class);

        $response = $this->createMock(Response::class);
        $response->method('statusCode')->willReturn(201);

        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);

        $status = new Status(new Url('http://localhost'), $client);
        $status->information();
    }
}
