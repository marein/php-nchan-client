<?php

declare(strict_types=1);

namespace Marein\Nchan\Http;

use Marein\Nchan\Exception\InvalidUrlException;

final class Url
{
    private string $value;

    /**
     * @throws InvalidUrlException
     */
    public function __construct(string $value)
    {
        $parsed = parse_url($value);

        if ($parsed === false) {
            throw new InvalidUrlException(
                sprintf(
                    'The url "%s" is malformed.',
                    $value
                )
            );
        }

        if (!isset($parsed['host']) && !isset($parsed['scheme'])) {
            throw new InvalidUrlException(
                sprintf(
                    'The url "%s" must at least consists of host and scheme.',
                    $value
                )
            );
        }

        $this->value = $value;
    }

    /**
     * @throws InvalidUrlException
     */
    public function append(string $value): Url
    {
        return new Url($this . $value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
