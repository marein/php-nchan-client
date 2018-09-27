<?php
declare(strict_types=1);

namespace Marein\Nchan\Api\Model;

abstract class Message
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $content;

    /**
     * Message constructor.
     *
     * @param string $name
     * @param string $content
     */
    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
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
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    abstract public function contentType(): string;
}
