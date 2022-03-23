<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Psr18ClientAdapter implements Client
{
    private ClientInterface $client;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function get(Request $request): Response
    {
        return $this->request('GET', $request);
    }

    public function post(Request $request): Response
    {
        return $this->request('POST', $request);
    }

    public function delete(Request $request): Response
    {
        return $this->request('DELETE', $request);
    }

    /**
     * @throws NchanException
     */
    private function request(string $method, Request $request): Response
    {
        try {
            $psrRequest = $this->requestFactory
                ->createRequest($method, $request->url()->toString())
                ->withBody($this->streamFactory->createStream($request->body()));

            foreach ($request->headers() as $name => $value) {
                $psrRequest = $psrRequest->withHeader($name, $value);
            }

            return new Psr7ResponseAdapter($this->client->sendRequest($psrRequest));
        } catch (ClientExceptionInterface $exception) {
            throw new NchanException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}
