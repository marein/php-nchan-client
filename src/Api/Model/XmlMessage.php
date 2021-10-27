<?php

declare(strict_types=1);

namespace Marein\Nchan\Api\Model;

final class XmlMessage extends Message
{
    public function contentType(): string
    {
        return 'application/xml';
    }
}
