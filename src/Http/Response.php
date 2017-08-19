<?php

namespace Marein\Nchan\Http;

interface Response
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NOT_FOUND = 404;

    /**
     * @return int
     */
    public function statusCode(): int;

    /**
     * @return string
     */
    public function body(): string;
}