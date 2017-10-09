<?php

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

interface Credentials
{
    /**
     * Authenticate the request.
     *
     * @param Request $request
     *
     * @return Request
     */
    public function authenticate(Request $request): Request;
}
