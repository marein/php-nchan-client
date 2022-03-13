<?php

declare(strict_types=1);

namespace Marein\Nchan\Tests\Integration\HttpAdapter;

use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\HttpAdapter\Psr18ClientAdapter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

class Psr18ClientAdapterTest extends ClientTestCase
{
    protected function createClient(Request $request): Client
    {
        $client = new Psr18Client(HttpClient::create());

        return new Psr18ClientAdapter(
            $client,
            $client,
            $client
        );
    }
}
