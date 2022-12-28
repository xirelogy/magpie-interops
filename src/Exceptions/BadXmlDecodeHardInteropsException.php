<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by failure in decoding the XML API return
 */
class BadXmlDecodeHardInteropsException extends BadDecodeHardInteropsException
{
    /**
     * Constructor
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        $message = $message ?? _l('The API response is not a valid XML');

        parent::__construct($message, $previous);
    }
}