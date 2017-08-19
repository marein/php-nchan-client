# php-nchan-client

This project is under development. The api (class and method names) might change.

## Roadmap to 1.0.0

* Unit tests
* Implement the group api
* Renaming things and documentation

## Extend with another HTTP Client library

Sometimes the shipped client is not enough and you want to use features from other libraries like guzzle.

### Guzzle

```php
<?php

namespace Your\Name\Space;

use Marein\Nchan\Http\Client;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleAdapter implements Client
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * GuzzleAdapter constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function get(Request $request): Response
    {
        return $this->request('GET', $request);
    }

    /**
     * @inheritdoc
     */
    public function post(Request $request): Response
    {
        return $this->request('POST', $request);
    }

    /**
     * @inheritdoc
     */
    public function delete(Request $request): Response
    {
        return $this->request('DELETE', $request);
    }

    /**
     * @param string  $method
     * @param Request $request
     *
     * @return Response
     * @throws NchanException
     */
    private function request(string $method, Request $request): Response
    {
        try {
            $response = $this->client->send(new \GuzzleHttp\Psr7\Request(
                $method,
                $request->url(),
                $request->headers(),
                $request->body()
            ));

            return $this->guzzleResponseAdapter($response);
        } catch (\Exception $exception) {
            throw new NchanException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    private function guzzleResponseAdapter(ResponseInterface $response)
    {
        return new class($response) implements Response
        {
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function statusCode(): int
            {
                return $this->response->getStatusCode();
            }

            public function body(): string
            {
                return $this->response->getBody();
            }
        };
    }
}
```