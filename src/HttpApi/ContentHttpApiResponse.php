<?php

namespace MagpieLib\Interops\HttpApi;

use Exception;
use Magpie\Facades\Http\Headers\HttpContentDisposition;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Concepts\BinaryContentable;
use Magpie\General\Contents\SimpleBinaryContent;
use Magpie\General\Names\CommonHttpHeader;
use Magpie\General\Names\CommonHttpStatusCode;
use Magpie\General\Names\CommonMimeType;
use Magpie\General\Traits\StaticClass;
use MagpieLib\Interops\Exceptions\BadContentDecodeHardInteropsException;
use MagpieLib\Interops\Exceptions\BadDecodeHardInteropsException;
use MagpieLib\Interops\Exceptions\BadHttpStatusResponseHardInteropsException;
use MagpieLib\Interops\Exceptions\BadResponseHardInteropsException;

/**
 * Expecting HTTP API response as file content
 */
class ContentHttpApiResponse
{
    use StaticClass;


    /**
     * Accept the response and decode the content
     * @param HttpClientResponse $response
     * @return BinaryContentable
     * @throws BadResponseHardInteropsException
     * @throws BadDecodeHardInteropsException
     */
    public static function accept(HttpClientResponse $response) : BinaryContentable
    {
        try {
            $httpStatusCode = $response->getHttpStatusCode();
            if ($httpStatusCode !== CommonHttpStatusCode::OK) throw new BadHttpStatusResponseHardInteropsException($httpStatusCode);

            $headers = $response->getHeaders();
            $filename = HttpContentDisposition::decodeFilename($headers->optional(CommonHttpHeader::CONTENT_DISPOSITION));
            $contentType = $headers->optional(CommonHttpHeader::CONTENT_TYPE, default: CommonMimeType::BINARY);
            $content = $response->getBody()->getData();

            return SimpleBinaryContent::create($content, $contentType, $filename);
        } catch (BadResponseHardInteropsException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            throw new BadContentDecodeHardInteropsException(previous: $ex);
        }
    }
}