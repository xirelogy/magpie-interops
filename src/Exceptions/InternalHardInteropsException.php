<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by internal error
 */
class InternalHardInteropsException extends HardInteropsException
{
    /**
     * Constructor
     * @param Throwable|null $previous
     */
    public function __construct(?Throwable $previous)
    {
        $message = _l('Internal error');

        parent::__construct($message, $previous);
    }
}