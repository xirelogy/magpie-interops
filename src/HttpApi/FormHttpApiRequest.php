<?php

namespace MagpieLib\Interops\HttpApi;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\Facades\Http\Bodies\HttpFormClientRequestBody;
use Magpie\Facades\Http\HttpClientPendingRequest;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Names\CommonHttpMethod;
use Magpie\Objects\UriBuilder;
use MagpieLib\Interops\Exceptions\CommonInteropsException;

/**
 * FORM HTTP based API request
 */
class FormHttpApiRequest extends CommonHttpApiRequest
{
    /**
     * Perform a POST request with FORM payload
     * @param UriBuilder|string $url
     * @param array|HttpFormClientRequestBody $payload
     * @param iterable $headers
     * @param iterable $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     */
    public function post(UriBuilder|string $url, array|HttpFormClientRequestBody $payload, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);

        $requestMakerFn = function () use ($urlBuilder, $payload) : HttpClientPendingRequest {
            $body = $payload instanceof HttpFormClientRequestBody ? $payload : new HttpFormClientRequestBody($payload);
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::POST, $urlBuilder)->withBody($body);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }


    /**
     * Perform a PUT request with FORM payload
     * @param UriBuilder|string $url
     * @param array|HttpFormClientRequestBody $payload
     * @param iterable $headers
     * @param iterable $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     */
    public function put(UriBuilder|string $url, array|HttpFormClientRequestBody $payload, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);

        $requestMakerFn = function () use ($urlBuilder, $payload) : HttpClientPendingRequest {
            $body = $payload instanceof HttpFormClientRequestBody ? $payload : new HttpFormClientRequestBody($payload);
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::PUT, $urlBuilder)->withBody($body);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }
}