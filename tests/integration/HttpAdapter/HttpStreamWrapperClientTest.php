<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Url;
use PHPUnit\Framework\TestCase;

class HttpStreamWrapperClientTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithDefaults(): void
    {
        HttpStreamWrapperClient::withDefaults();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function itShouldPerformGetRequest(): void
    {
        $request = new Request(
            new Url(getenv('INTEGRATION_TEST_BASE_URL') . '?statusCode=201'),
            [
                'Accept' => 'application/json'
            ]
        );

        $credentials = $this->createMock(Credentials::class);
        $credentials->expects($this->once())->method('authenticate')->willReturn($request);

        $client = new HttpStreamWrapperClient($credentials);

        $response = $client->get($request);

        $serverResponse = unserialize($response->body());

        $this->assertSame(201, $response->statusCode());
        $this->assertSame('application/json', $serverResponse['SERVER']['HTTP_ACCEPT']);
    }

    /**
     * @test
     */
    public function itShouldPerformPostRequest(): void
    {
        $request = new Request(
            new Url(getenv('INTEGRATION_TEST_BASE_URL') . '?statusCode=201'),
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            http_build_query([
                'message' => 'my-message-name'
            ])
        );

        $credentials = $this->createMock(Credentials::class);
        $credentials->expects($this->once())->method('authenticate')->willReturn($request);

        $client = new HttpStreamWrapperClient($credentials);

        $response = $client->post($request);

        $serverResponse = unserialize($response->body());

        $this->assertSame(201, $response->statusCode());
        $this->assertSame('application/json', $serverResponse['SERVER']['HTTP_ACCEPT']);
        $this->assertSame('my-message-name', $serverResponse['POST']['message']);
    }

    /**
     * @test
     */
    public function itShouldPerformDeleteRequest(): void
    {
        $request = new Request(
            new Url(getenv('INTEGRATION_TEST_BASE_URL') . '?statusCode=201'),
            [
                'Accept' => 'application/json'
            ]
        );

        $credentials = $this->createMock(Credentials::class);
        $credentials->expects($this->once())->method('authenticate')->willReturn($request);

        $client = new HttpStreamWrapperClient($credentials);

        $response = $client->delete($request);

        $serverResponse = unserialize($response->body());

        $this->assertSame(201, $response->statusCode());
        $this->assertSame('application/json', $serverResponse['SERVER']['HTTP_ACCEPT']);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnInvalidResponse(): void
    {
        $this->expectException(NchanException::class);

        $request = new Request(
            new Url('http://invalid.url'),
            [
                'Accept' => 'application/json'
            ]
        );

        $credentials = $this->createMock(Credentials::class);
        $credentials->expects($this->once())->method('authenticate')->willReturn($request);

        $client = new HttpStreamWrapperClient($credentials);

        $client->get($request);
    }
}
