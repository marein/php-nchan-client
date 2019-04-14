<?php
declare(strict_types=1);

namespace Marein\Nchan\Tests\TestServer;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;
use Symfony\Component\Process\Process;

final class PhpUnitStartServerListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @var string
     */
    private $suiteName;

    /**
     * @var string
     */
    private $socket;

    /**
     * @var string
     */
    private $documentRoot;

    /**
     * PhpUnitStartServerListener constructor.
     *
     * @param string $suiteName
     * @param string $socket
     * @param string $documentRoot
     */
    public function __construct(string $suiteName, string $socket, string $documentRoot)
    {
        $this->suiteName = $suiteName;
        $this->socket = $socket;
        $this->documentRoot = $documentRoot;
    }

    /**
     * @inheritdoc
     */
    public function startTestSuite(TestSuite $suite): void
    {
        if ($suite->getName() === $this->suiteName) {
            $process = new Process(
                [
                    'php',
                    '-S',
                    $this->socket,
                    $this->documentRoot
                ]
            );
            $process->start();

            // Wait for the server.
            sleep(1);
        }
    }
}
