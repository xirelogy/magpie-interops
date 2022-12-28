<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by bad signature (failure in signature validation)
 */
class BadSignatureHardInteropsException extends HardInteropsException
{
    /**
     * Constructor
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(?string $message = null, ?Throwable $previous = null)
    {
        $message = $message ?? _l('Bad signature');

        parent::__construct($message, $previous);
    }
}