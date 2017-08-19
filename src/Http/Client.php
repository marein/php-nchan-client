<?php

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\NchanException;

interface Client
{
    /**
     * Make a GET request.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function get(Request $request): Response;

    /**
     * Make a POST request.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function post(Request $request): Response;

    /**
     * Make a DELETE request.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function delete(Request $request): Response;
}