<?php

namespace Marein\Nchan\Http;

final class Url
{
    /**
     * @var string
     */
    private $value;

    /**
     * Url constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $parsed = parse_url($value);

        if ($parsed === false) {
            throw new \InvalidArgumentException();
        }

        if (!isset($parsed['host']) && !isset($parsed['scheme'])) {
            throw new \InvalidArgumentException();
        }

        $this->value = $value;
    }

    /**
     * @param string $value
     *
     * @return Url
     */
    public function append(string $value): Url
    {
        return new Url((string)$this . $value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}