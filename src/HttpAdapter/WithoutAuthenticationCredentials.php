<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

class WithoutAuthenticationCredentials implements Credentials
{
    /**
     * @inheritdoc
     */
    public function authenticate(Request $request): Request
    {
        return $request;
    }
}