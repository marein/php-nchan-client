<?php
declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Exception\NchanException;
use PHPUnit\Framework\TestCase;

class HttpStreamWrapperResponseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeCreatedWithItsValues(): void
    {
        $expectedStatusCode = 200;
        $expectedBody = 'my body';

        $response = new HttpStreamWrapperResponse($expectedStatusCode, $expectedBody);

        $this->assertEquals($expectedStatusCode, $response->statusCode());
        $this->assertEquals($expectedBody, $response->body());
    }

    /**
     * @test
     */
    public function itShouldBeCreatedFromStreamWrapperResponse(): void
    {
        $expectedStatusCode = 200;
        $expectedBody = 'my body';

        $response = HttpStreamWrapperResponse::fromResponse([
            'HTTP\1.1 200 OK'
        ], $expectedBody);

        $this->assertEquals($expectedStatusCode, $response->statusCode());
        $this->assertEquals($expectedBody, $response->body());
    }

    /**
     * @test
     * @dataProvider incorrectResponseHeadersProvider
     */
    public function itShouldThrowAnExceptionWhenIncorrectResponseHeadersArePassed(array $headers): void
    {
        $this->expectException(NchanException::class);

        HttpStreamWrapperResponse::fromResponse($headers, '');
    }

    /**
     * Returns various incorrect response headers.
     *
     * @return array
     */
    public function incorrectResponseHeadersProvider(): array
    {
        return [
            [['wrong response header']],
            [['HTT 200 OK']],
            [['HTTP/1.1 OK']],
            [['HTTP/1.1 -123']],
            [['']],
            [[]]
        ];
    }
}
