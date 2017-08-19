<?php

namespace Marein\Nchan\Http\Adapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;

final class FileGetContents implements Client
{
    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * FileGetContents constructor.
     */
    public function __construct()
    {
        $this->credentials = $this->withoutAuthentication();
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
        $request = $this->credentials->authenticate($request);

        $url = $request->url();
        $headers = $request->headers();
        $body = $request->body();

        $options = [
            'http' =>
                [
                    'method'        => $method,
                    'header'        => $this->prepareHeadersForStreamContext($headers),
                    'content'       => $body,
                    'ignore_errors' => true
                ]
        ];

        $context = stream_context_create($options);

        $responseBody = file_get_contents(
            $url,
            false,
            $context
        );

        if ($responseBody === false) {
            throw new NchanException('Unable to connect to ' . $url);
        }

        return FileGetContentsResponse::fromResponse($http_response_header, $responseBody);
    }

    /**
     * @param array $headers
     *
     * @return string
     */
    private function prepareHeadersForStreamContext(array $headers): string
    {
        return implode("\r\n", array_map(function (string $name, string $value) {
            return $name . ': ' . $value;
        }, array_keys($headers), $headers));
    }

    /**
     * @return Credentials
     */
    public function withoutAuthentication(): Credentials
    {
        return new class implements Credentials
        {
            public function authenticate(Request $request): Request
            {
                return $request;
            }
        };
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return Credentials
     */
    public function withBasicAuthentication(string $username, string $password): Credentials
    {
        $this->credentials = new class($username, $password) implements Credentials
        {
            private $username, $password;

            public function __construct(string $username, string $password)
            {
                $this->username = $username;
                $this->password = $password;
            }

            public function authenticate(Request $request): Request
            {
                $headers = $request->headers();

                $encodedCredentials = base64_encode($this->username . ':' . $this->password);

                $headers['Authorization'] = 'Basic ' . $encodedCredentials;

                return new Request(
                    $request->url(),
                    $headers,
                    $request->body()
                );
            }
        };
    }

    /**
     * @param string $token
     *
     * @return Credentials
     */
    public function withBearerAuthentication(string $token): Credentials
    {
        $this->credentials = new class($token) implements Credentials
        {
            private $token;

            public function __construct(string $token)
            {
                $this->token = $token;
            }

            public function authenticate(Request $request): Request
            {
                $headers = $request->headers();

                $headers['Authorization'] = 'Bearer ' . $this->token;

                return new Request(
                    $request->url(),
                    $headers,
                    $request->body()
                );
            }
        };
    }
}