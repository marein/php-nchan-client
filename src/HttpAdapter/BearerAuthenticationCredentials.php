<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

class BearerAuthenticationCredentials implements Credentials
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function authenticate(Request $request): Request
    {
        $headers = $request->headers();

        $headers['Authorization'] = 'Bearer ' . $this->token;

        return new Request(
            $request->url(),
            $headers,
            $request->body()
        );
    }
}
