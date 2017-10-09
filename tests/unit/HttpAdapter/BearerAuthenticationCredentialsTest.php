<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Url;
use PHPUnit\Framework\TestCase;

class BearerAuthenticationCredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExpandTheRequestWithAuthenticationHeader(): void
    {
        $token = 'my-token';
        $credentials = new BearerAuthenticationCredentials($token);

        $expectedAuthorizationHeaderValue = 'Bearer ' . $token;

        $request = $credentials->authenticate(new Request(
            new Url('http://localhost'),
            []
        ));

        $this->assertTrue($request->headers()['Authorization'] === $expectedAuthorizationHeaderValue);
    }

    /**
     * @test
     */
    public function itShouldOverrideAnExistingAuthenticationHeader(): void
    {
        $token = 'my-token';
        $credentials = new BearerAuthenticationCredentials($token);

        $expectedAuthorizationHeaderValue = 'Bearer ' . $token;

        $request = $credentials->authenticate(new Request(
            new Url('http://localhost'),
            [
                'Authorization' => 'Token other-token'
            ]
        ));

        $this->assertTrue($request->headers()['Authorization'] === $expectedAuthorizationHeaderValue);
    }
}