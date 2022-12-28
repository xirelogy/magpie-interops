<?php

namespace MagpieLib\Interops\HttpApi;

use Exception;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Simples\SimpleJSON;
use Magpie\General\Traits\StaticClass;
use MagpieLib\Interops\Exceptions\BadDecodeHardInteropsException;
use MagpieLib\Interops\Exceptions\BadJsonDecodeHardInteropsException;

/**
 * Expecting HTTP API response in JSON
 */
class JsonHttpApiResponse
{
    use StaticClass;


    /**
     * Accept the response and decode the JSON
     * @param HttpClientResponse $response
     * @return mixed
     * @throws BadDecodeHardInteropsException
     */
    public static function accept(HttpClientResponse $response) : mixed
    {
        try {
            return SimpleJSON::decode($response->getBody()->getData());
        } catch (Exception $ex) {
            throw new BadJsonDecodeHardInteropsException(previous: $ex);
        }
    }


    /**
     * Accept the response and decode the JSON as object
     * @param HttpClientResponse $response
     * @return object
     * @throws BadDecodeHardInteropsException
     */
    public static function acceptObject(HttpClientResponse $response) : object
    {
        $decoded = static::accept($response);
        if (!is_object($decoded)) throw new BadJsonDecodeHardInteropsException();

        return $decoded;
    }
}