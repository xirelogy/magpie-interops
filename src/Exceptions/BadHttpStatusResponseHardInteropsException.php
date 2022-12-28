<?php

namespace MagpieLib\Interops\Exceptions;

use Throwable;

/**
 * A hard interoperability exception caused by bad HTTP status
 */
class BadHttpStatusResponseHardInteropsException extends BadResponseHardInteropsException
{
    /**
     * @var int The bad HTTP status code received
     */
    public readonly int $httpStatusCode;


    /**
     * Constructor
     * @param int $httpStatusCode
     * @param Throwable|null $previous
     */
    public function __construct(int $httpStatusCode, ?Throwable $previous = null)
    {
        $message = static::formatMessage($httpStatusCode);

        parent::__construct($message, $previous);

        $this->httpStatusCode = $httpStatusCode;
    }


    /**
     * Format message
     * @param int $httpStatusCode
     * @return string
     */
    protected static function formatMessage(int $httpStatusCode) : string
    {
        return _format_safe(_l('HTTP/{{0}} in API response'), $httpStatusCode) ??
            _l('Bad HTTP status in API response');
    }
}