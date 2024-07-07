<?php

namespace MagpieLib\Interops\HttpApi;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\Facades\Http\Bodies\HttpJsonClientRequestBody;
use Magpie\Facades\Http\HttpClientPendingRequest;
use Magpie\Facades\Http\HttpClientRequestOption;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Names\CommonHttpMethod;
use Magpie\Objects\UriBuilder;
use MagpieLib\Interops\Exceptions\CommonInteropsException;

/**
 * JSON HTTP based API request
 */
class JsonHttpApiRequest extends CommonHttpApiRequest
{
    /**
     * Perform a POST request with JSON payload
     * @param UriBuilder|string $url
     * @param array|object|HttpJsonClientRequestBody $payload
     * @param iterable<string, mixed> $headers
     * @param iterable<HttpClientRequestOption> $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     * @noinspection PhpDocSignatureInspection
     */
    public function post(UriBuilder|string $url, array|object $payload, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);

        $requestMakerFn = function () use ($urlBuilder, $payload) : HttpClientPendingRequest {
            $body = $payload instanceof HttpJsonClientRequestBody ? $payload : new HttpJsonClientRequestBody($payload);
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::POST, $urlBuilder)->withBody($body);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }


    /**
     * Perform a PUT request with JSON payload
     * @param UriBuilder|string $url
     * @param array|object|HttpJsonClientRequestBody $payload
     * @param iterable<string, mixed> $headers
     * @param iterable<HttpClientRequestOption> $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     * @noinspection PhpDocSignatureInspection
     */
    public function put(UriBuilder|string $url, array|object $payload, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);

        $requestMakerFn = function () use ($urlBuilder, $payload) : HttpClientPendingRequest {
            $body = $payload instanceof HttpJsonClientRequestBody ? $payload : new HttpJsonClientRequestBody($payload);
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::PUT, $urlBuilder)->withBody($body);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }
}