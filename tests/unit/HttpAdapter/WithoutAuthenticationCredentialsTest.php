<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;
use PHPUnit\Framework\TestCase;

class WithoutAuthenticationCredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnTheSameRequest(): void
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