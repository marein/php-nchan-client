<?php
declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;

final class HttpStreamWrapperClient implements Client
{
    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * HttpStreamWrapperClient constructor.
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Create an instance without authentication enabled.
     *
     * @return HttpStreamWrapperClient
     */
    public static function withDefaults(): HttpStreamWrapperClient
    {
        return new self(
            new WithoutAuthenticationCredentials()
        );
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
     * Perform a request.
     *
     * @param string  $method
     * @param Request $request
     *
     * @return Response
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
                    'method'        => $method,
                    'header'        => $this->prepareHeadersForStreamContext($headers),
                    'content'       => $body,
                    'ignore_errors' => true
                ]
        ];

        $context = stream_context_create($options);

        $responseBody = @file_get_contents(
            $url,
            false,
            $context
        );

        if ($responseBody === false) {
            throw new NchanException('Unable to connect to ' . $url . '.');
        }

        return HttpStreamWrapperResponse::fromResponse($http_response_header, $responseBody);
    }

    /**
     * Prepare the given headers for stream context.
     *
     * Transform the array from
     * [
     *   'firstHeaderName' => 'firstHeaderValue',
     *   'secondHeaderName' => 'secondHeaderValue'
     * ]
     * to string
     * "firstHeaderName: firstHeaderValue\r\n
     *  secondHeaderName: secondHeaderValue".
     *
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
}
