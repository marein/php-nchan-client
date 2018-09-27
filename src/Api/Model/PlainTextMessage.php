<?php
declare(strict_types=1);

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
