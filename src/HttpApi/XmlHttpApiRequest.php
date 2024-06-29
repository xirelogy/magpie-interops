<?php

namespace MagpieLib\Interops\HttpApi;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\Facades\Http\Bodies\HttpXmlClientRequestBody;
use Magpie\Facades\Http\HttpClientPendingRequest;
use Magpie\Facades\Http\HttpClientRequestOption;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Names\CommonHttpMethod;
use Magpie\Objects\UriBuilder;
use MagpieLib\Interops\Exceptions\CommonInteropsException;

/**
 * XML HTTP based API request
 */
class XmlHttpApiRequest extends CommonHttpApiRequest
{
    /**
     * Perform a POST request with XML payload
     * @param UriBuilder|string $url
     * @param HttpXmlClientRequestBody|object $payload
     * @param iterable<string, mixed> $headers
     * @param iterable<HttpClientRequestOption> $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     * @noinspection PhpDocSignatureInspection
     */
    public function post(UriBuilder|string $url, object $payload, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);

        $requestMakerFn = function () use ($urlBuilder, $payload) : HttpClientPendingRequest {
            $body = $payload instanceof HttpXmlClientRequestBody ? $payload : new HttpXmlClientRequestBody($payload);
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::POST, $urlBuilder)->withBody($body);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }
}