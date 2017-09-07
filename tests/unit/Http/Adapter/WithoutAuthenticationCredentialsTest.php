<?php

namespace Marein\Nchan\Http\Adapter;

use Marein\Nchan\Http\Request;
use PHPUnit\Framework\TestCase;

class WithoutAuthenticationCredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExpandTheRequestWithAuthenticationHeader(): void
    {
        $credentials = new WithoutAuthenticationCredentials();

        $expectedRequest = new Request(
            'http://localhost',
            []
        );

        $request = $credentials->authenticate($expectedRequest);

        $this->assertSame($expectedRequest, $request);
    }
}