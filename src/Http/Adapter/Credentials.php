<?php

namespace Marein\Nchan\Http\Adapter;

use Marein\Nchan\Http\Request;

interface Credentials
{
    public function authenticate(Request $request): Request;
}