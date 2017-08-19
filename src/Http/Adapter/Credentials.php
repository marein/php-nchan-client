<?php

namespace Marein\Nchan\Http\Adapter;

use Marein\Nchan\Http\Request;

interface Credentials
{
    /**
     * @param Request $request
     *
     * @return Request
     */
    public function authenticate(Request $request): Request;
}