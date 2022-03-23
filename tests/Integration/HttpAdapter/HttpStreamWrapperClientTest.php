<?php

declare(strict_types=1);

namespace Marein\Nchan\Tests\Integration\HttpAdapter;

use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\HttpAdapter\Credentials;
use Marein\Nchan\HttpAdapter\HttpStreamWrapperClient;

class HttpStreamWrapperClientTest extends ClientTestCase
{
    protected function createClient(Request $request): Client
    {
        $credentials = $this->createMock(Credentials::class);
        $credentials->expects($this->once())->method('authenticate')->willReturn($request);

        return new HttpStreamWrapperClient($credentials);
    }

    /**
     * @test
     */
    public function itShouldBeCreatedWithDefaults(): void
    {
        HttpStreamWrapperClient::withDefaults();

        $this->assertTrue(true);
    }
}
