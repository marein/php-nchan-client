<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

class BasicAuthenticationCredentials implements Credentials
{
    private string $username;

    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate(Request $request): Request
    {
        $headers = $request->headers();

        $encodedCredentials = base64_encode($this->username . ':' . $this->password);

        $headers['Authorization'] = 'Basic ' . $encodedCredentials;

        return new Request(
            $request->url(),
            $headers,
            $request->body()
        );
    }
}
