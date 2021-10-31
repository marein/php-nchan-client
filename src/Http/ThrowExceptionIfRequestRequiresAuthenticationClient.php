<?php

declare(strict_types=1);

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\AuthenticationRequiredException;

class ThrowExceptionIfRequestRequiresAuthenticationClient implements Client
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(Request $request): Response
    {
        return $this->throwExceptionIfRequestRequiresAuthenticationOrReturnResponse(
            'GET',
            $request,
            $this->client->get($request)
        );
    }

    public function post(Request $request): Response
    {
        return $this->throwExceptionIfRequestRequiresAuthenticationOrReturnResponse(
            'POST',
            $request,
            $this->client->post($request)
        );
    }

    public function delete(Request $request): Response
    {
        return $this->throwExceptionIfRequestRequiresAuthenticationOrReturnResponse(
            'DELETE',
            $request,
            $this->client->delete($request)
        );
    }

    /**
     * @throws AuthenticationRequiredException
     */
    private function throwExceptionIfRequestRequiresAuthenticationOrReturnResponse(
        string $method,
        Request $request,
        Response $response
    ): Response {
        if ($response->statusCode() === Response::FORBIDDEN) {
            throw new AuthenticationRequiredException(
                sprintf(
                    'Request to "%s %s" requires authentication.',
                    $method,
                    $request->url()
                )
            );
        }

        return $response;
    }
}
