<?php

namespace Marein\Nchan\HttpAdapter;

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
     *
     * @param Credentials|null $credentials
     */
    public function __construct(Credentials $credentials = null)
    {
        $this->credentials = $credentials ? $credentials : new WithoutAuthenticationCredentials();
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
     * Returns a new instance without authentication.
     *
     * @return FileGetContents
     */
    public function withoutAuthentication(): FileGetContents
    {
        return new self();
    }

    /**
     * Returns a new instance with basic authentication.
     *
     * @param string $username
     * @param string $password
     *
     * @return FileGetContents
     */
    public function withBasicAuthentication(string $username, string $password): FileGetContents
    {
        return new self(
            new BasicAuthenticationCredentials($username, $password)
        );
    }

    /**
     * Returns a new instance with bearer authentication.
     *
     * @param string $token
     *
     * @return FileGetContents
     */
    public function withBearerAuthentication(string $token): FileGetContents
    {
        return new self(
            new BearerAuthenticationCredentials($token)
        );
    }
}