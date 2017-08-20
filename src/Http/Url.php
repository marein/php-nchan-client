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
            throw new \InvalidArgumentException($value . ' is not a valid url.');
        }

        if (!isset($parsed['host']) && !isset($parsed['scheme'])) {
            throw new \InvalidArgumentException('The url ' . $value . ' must at least consists of host and scheme.');
        }

        $this->value = $value;
    }

    /**
     * Returns the new Url with the concatenated values.
     *
     * @param string $value
     *
     * @return Url
     */
    public function append(string $value): Url
    {
        return new Url((string)$this . $value);
    }

    /**
     * Returns the url.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Returns the url.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }
}