<?php

namespace {

    use PHPUnit\Framework\BaseTestListener;
    use PHPUnit\Framework\TestSuite;
    use Symfony\Component\Process\Process;

    final class PhpUnitStartServerListener extends BaseTestListener
    {
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
            parent::startTestSuite($suite);

            if ($suite->getName() === $this->suiteName) {
                $process = new Process(
                    sprintf(
                        'php -S %s %s',
                        $this->socket,
                        $this->documentRoot
                    )
                );
                $process->start();

                // Wait for the server.
                sleep(1);
            }
        }
    }
}
