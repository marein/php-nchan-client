<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

interface Credentials
{
    public function authenticate(Request $request): Request;
}
