<?php

declare(strict_types=1);

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\NchanException;

interface Client
{
    /**
     * @throws NchanException
     */
    public function get(Request $request): Response;

    /**
     * @throws NchanException
     */
    public function post(Request $request): Response;

    /**
     * @throws NchanException
     */
    public function delete(Request $request): Response;
}
