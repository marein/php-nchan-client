<?php

namespace Marein\Nchan\Api\Model;

final class XmlMessage extends Message
{
    /**
     * @inheritdoc
     */
    public function contentType(): string
    {
        return 'application/xml';
    }
}