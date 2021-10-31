<?php

declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;

final class HttpStreamWrapperClient implements Client
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public static function withDefaults(): HttpStreamWrapperClient
    {
        return new self(
            new WithoutAuthenticationCredentials()
        );
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
        $request = $this->credentials->authenticate($request);

        $url = $request->url()->toString();
        $headers = $request->headers();
        $body = $request->body();

        $options = [
            'http' =>
                [
                    'method' => $method,
                    'header' => $this->prepareHeadersForStreamContext($headers),
                    'content' => $body,
                    'ignore_errors' => true
                ]
        ];

        $context = stream_context_create($options);

        // Suppress errors for file_get_contents. We will analyze this ourselves.
        $errorReportingLevelBeforeFileGetContents = error_reporting(0);

        $responseBody = file_get_contents(
            $url,
            false,
            $context
        );

        error_reporting($errorReportingLevelBeforeFileGetContents);

        if ($responseBody === false) {
            throw new NchanException(
                error_get_last()['message'] ?? 'Unable to connect to ' . $url . '.'
            );
        }

        return HttpStreamWrapperResponse::fromResponse($http_response_header, $responseBody);
    }

    /**
     * Transforms the array from
     * [
     *   'firstHeaderName' => 'firstHeaderValue',
     *   'secondHeaderName' => 'secondHeaderValue'
     * ]
     * to string
     * "firstHeaderName: firstHeaderValue\r\n
     *  secondHeaderName: secondHeaderValue".
     *
     * @param array<string, string> $headers
     */
    private function prepareHeadersForStreamContext(array $headers): string
    {
        return implode(
            "\r\n",
            array_map(
                static fn(string $name, string $value) => $name . ': ' . $value,
                array_keys($headers),
                $headers
            )
        );
    }
}
