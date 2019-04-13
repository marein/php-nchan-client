<?php
declare(strict_types=1);

namespace Marein\Nchan\Tests\Unit;

use Marein\Nchan\Api\Channel;
use Marein\Nchan\Api\Status;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Nchan;
use PHPUnit\Framework\TestCase;

class NchanTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateChannelApi(): void
    {
        $channel = $this->createNchan()->channel('/my-channel');

        $this->assertInstanceOf(Channel::class, $channel);
    }

    /**
     * @test
     */
    public function itShouldCreateStatusApi(): void
    {
        $status = $this->createNchan()->status('/status');

        $this->assertInstanceOf(Status::class, $status);
    }

    /**
     * Returns a Nchan instance.
     *
     * @return Nchan
     */
    private function createNchan(): Nchan
    {
        $client = $this->createMock(Client::class);

        $nchan = new Nchan(
            'http://localhost',
            $client
        );

        return $nchan;
    }
}
