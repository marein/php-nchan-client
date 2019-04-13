<?php
declare(strict_types=1);

namespace Marein\Nchan\Tests\Unit\HttpAdapter;

use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Url;
use Marein\Nchan\HttpAdapter\BasicAuthenticationCredentials;
use PHPUnit\Framework\TestCase;

class BasicAuthenticationCredentialsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldExpandTheRequestWithAuthenticationHeader(): void
    {
        $username = 'starwars';
        $password = '25.05.1977';
        $credentials = new BasicAuthenticationCredentials($username, $password);

        $expectedAuthorizationHeaderValue = 'Basic ' . base64_encode($username . ':' . $password);

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
        $username = 'starwars';
        $password = '25.05.1977';
        $credentials = new BasicAuthenticationCredentials($username, $password);

        $expectedAuthorizationHeaderValue = 'Basic ' . base64_encode($username . ':' . $password);

        $request = $credentials->authenticate(new Request(
            new Url('http://localhost'),
            [
                'Authorization' => 'Token my-token'
            ]
        ));

        $this->assertTrue($request->headers()['Authorization'] === $expectedAuthorizationHeaderValue);
    }
}
