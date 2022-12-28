<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by bad timestamp (outside the allowable timestamp range)
 */
class BadTimestampHardInteropsException extends HardInteropsException
{
    /**
     * Constructor
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        $message = $message ?? _l('Bad timestamp');

        parent::__construct($message, $previous);
    }
}