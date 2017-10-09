<?php

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\AuthenticationRequiredException;
use PHPUnit\Framework\TestCase;

class ThrowExceptionIfRequestRequiresAuthenticationClientTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldThrowExceptionOnForbiddenGetRequest(): void
    {
        $this->expectException(AuthenticationRequiredException::class);

        $client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $this->createForbiddenClient()
        );

        $client->get(new Request(new Url('http://localhost'), []));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnForbiddenPostRequest(): void
    {
        $this->expectException(AuthenticationRequiredException::class);

        $client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $this->createForbiddenClient()
        );

        $client->post(new Request(new Url('http://localhost'), []));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionOnForbiddenDeleteRequest(): void
    {
        $this->expectException(AuthenticationRequiredException::class);

        $client = new ThrowExceptionIfRequestRequiresAuthenticationClient(
            $this->createForbiddenClient()
        );

        $client->delete(new Request(new Url('http://localhost'), []));
    }

    /**
     * @return Client
     */
    private function createForbiddenClient(): Client
    {
        return new class implements Client
        {
            public function get(Request $request): Response
            {
                return $this->createForbiddenResponse();
            }

            public function post(Request $request): Response
            {
                return $this->createForbiddenResponse();
            }

            public function delete(Request $request): Response
            {
                return $this->createForbiddenResponse();
            }

            private function createForbiddenResponse(): Response
            {
                return new class implements Response
                {
                    public function statusCode(): int
                    {
                        return Response::FORBIDDEN;
                    }

                    public function body(): string
                    {
                        return '';
                    }
                };
            }
        };
    }
}