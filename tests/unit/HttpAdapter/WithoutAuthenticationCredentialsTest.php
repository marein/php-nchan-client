<?php
declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Url;
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
            new Url('http://localhost'),
            []
        );

        $request = $credentials->authenticate($expectedRequest);

        $this->assertSame($expectedRequest, $request);
    }
}
