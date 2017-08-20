<?php

namespace Marein\Nchan\Http\Adapter;

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