<?php
declare(strict_types=1);

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
