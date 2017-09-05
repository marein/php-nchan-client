<?php

namespace Marein\Nchan\Api\Model;

final class PlainTextMessage extends Message
{
    /**
     * @inheritdoc
     */
    public function contentType(): string
    {
        return 'text/plain';
    }
}