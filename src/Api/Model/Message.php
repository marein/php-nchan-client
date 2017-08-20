<?php

namespace Marein\Nchan\Api\Model;

final class Message
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $payload;

    /**
     * Message constructor.
     *
     * @param string $name
     * @param string $payload
     */
    public function __construct(string $name, string $payload)
    {
        $this->name = $name;
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function payload(): string
    {
        return $this->payload;
    }
}