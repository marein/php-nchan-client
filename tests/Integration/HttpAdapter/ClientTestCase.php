<?php

declare(strict_types=1);

namespace Marein\Nchan\Tests\Integration\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Url;
use Marein\Nchan\HttpAdapter\Credentials;
use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;
use PHPUnit\Framework\TestCase;

abstract class ClientTestCase extends TestCase
{
    abstract protected function createClient(Request $request): Client;

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

        $client = $this->createClient($request);

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
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            http_build_query(
                [
                    'message' => 'my-message-name'
                ]
            )
        );

        $client = $this->createClient($request);

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

        $client = $this->createClient($request);

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
            new Url(getenv('INTEGRATION_TEST_INVALID_BASE_URL')),
            [
                'Accept' => 'application/json'
            ]
        );

        $client = $this->createClient($request);

        $client->get($request);
    }
}
