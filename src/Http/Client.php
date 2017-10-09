<?php

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\NchanException;

interface Client
{
    /**
     * Make a GET request.
     * If something goes wrong, the client must throw an exception of type \Marein\Nchan\Exception\NchanException.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function get(Request $request): Response;

    /**
     * Make a POST request.
     * If something goes wrong, the client must throw an exception of type \Marein\Nchan\Exception\NchanException.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function post(Request $request): Response;

    /**
     * Make a DELETE request.
     * If something goes wrong, the client must throw an exception of type \Marein\Nchan\Exception\NchanException.
     *
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    public function delete(Request $request): Response;
}
