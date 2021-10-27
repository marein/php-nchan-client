<?php

declare(strict_types=1);

namespace Marein\Nchan\Http;

interface Response
{
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;

    public function statusCode(): int;

    public function body(): string;
}
