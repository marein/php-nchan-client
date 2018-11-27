<?php
declare(strict_types=1);

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

        if (!isset($parsed['host']) && !isset($parsed['scheme'])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The url "%s" must at least consists of host and scheme.',
                    $value
                )
            );
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
        return new Url($this . $value);
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
