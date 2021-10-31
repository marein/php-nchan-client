<?php

declare(strict_types=1);

namespace Marein\Nchan\Api\Model;

abstract class Message
{
    private string $name;

    private string $content;

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function content(): string
    {
        return $this->content;
    }

    abstract public function contentType(): string;
}
