<?php

namespace Marein\Nchan\HttpAdapter;

use PHPUnit\Framework\TestCase;

class HttpStreamWrapperClientTest extends TestCase
{
    /**
     * @test
     */
    public function dummy(): void
    {
        /**
         * We can not unit test this class. I looked into the promising
         * https://github.com/php-vcr/php-vcr
         * project, but unfortunately they found no way to set the local scope
         * variable $http_response_header we need. I also considered to rewrite the client from
         * file_get_contents to fopen, but the return of stream_get_meta_data
         * (which returns the http headers in that case) is an object of the stream wrapper instance from php-vcr.
         * When we use this, we must check the instance of the return value from stream_get_meta_data
         * in our HttpStreamWrapperClient. I don't want to write code just for test cases.
         * However, this class is covered with an integration test.
         */
        $this->assertTrue(true);
    }
}