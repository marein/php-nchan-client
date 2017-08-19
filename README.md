# php-nchan-client

__Note: This project is under development. The api (class and method names) might change.__

This is a PHP client for [https://nchan.io](https://nchan.io).

## Roadmap to 1.0.0

* Unit tests
* Implement the group api
* Renaming things and code documentation

## Usage

### Publish a message

```php
<?php

namespace {

    include '/path/to/autoload.php';

    use Marein\Nchan\Message;
    use Marein\Nchan\Nchan;

    $nchan = new Nchan('http://my-nchan-domain');  
    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->publish(new Message(
        'event_name',
        'payload'
    ));

    // Nchan returns some channel information after publishing a message.
    var_dump($channelInformation);
}
```

### Get channel information

```php
<?php

namespace {

    include '/path/to/autoload.php';

    use Marein\Nchan\Nchan;

    $nchan = new Nchan('http://my-nchan-domain');  
    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->information();

    var_dump($channelInformation);
}
```

### Delete a channel

```php
<?php

namespace {

    include '/path/to/autoload.php';

    use Marein\Nchan\Nchan;

    $nchan = new Nchan('http://my-nchan-domain');  
    $isDeleted = $nchan->channel('/path-to-publisher-endpoint')->delete();
}
```

### Basic nchan information

First you have to create a location with the "nchan_stub_status;" directive. Then you can query it.

```php
<?php

namespace {

    include '/path/to/autoload.php';

    use Marein\Nchan\Nchan;

    $nchan = new Nchan('http://my-nchan-domain');  
    $statusInformation = $nchan->status('/path-to-status-location')->information();

    var_dump($statusInformation);
}
```

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