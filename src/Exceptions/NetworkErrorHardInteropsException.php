<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by network error
 */
class NetworkErrorHardInteropsException extends BadResponseHardInteropsException
{
    /**
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        $message = $message ?? _l('Network error during API request');

        parent::__construct($message, $previous);
    }
}