<?php

namespace MagpieLib\Interops\HttpApi;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\Facades\Http\HttpClientPendingRequest;
use Magpie\Facades\Http\HttpClientRequestOption;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Names\CommonHttpMethod;
use Magpie\Objects\UriBuilder;
use MagpieLib\Interops\Exceptions\CommonInteropsException;

/**
 * Simple HTTP based API request
 */
class SimpleHttpApiRequest extends CommonHttpApiRequest
{
    /**
     * Perform a 'GET' request
     * @param UriBuilder|string $url
     * @param iterable<string, mixed> $args
     * @param iterable<string, mixed> $headers
     * @param iterable<HttpClientRequestOption> $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     */
    public function get(UriBuilder|string $url, iterable $args, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);
        $urlBuilder->withQueries($args);

        $requestMakerFn = function () use ($urlBuilder) : HttpClientPendingRequest {
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::GET, $urlBuilder);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }


    /**
     * Perform a 'HEAD' request
     * @param UriBuilder|string $url
     * @param iterable<string, mixed> $args
     * @param iterable<string, mixed> $headers
     * @param iterable<HttpClientRequestOption> $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     */
    public function head(UriBuilder|string $url, iterable $args, iterable $headers = [], iterable $options = []) : HttpClientResponse
    {
        $urlBuilder = $url instanceof UriBuilder ? $url : UriBuilder::parse($url);
        $urlBuilder->withQueries($args);

        $requestMakerFn = function () use ($urlBuilder) : HttpClientPendingRequest {
            return $this->initializeHttpClient()->prepare(CommonHttpMethod::HEAD, $urlBuilder);
        };

        return $this->runRequest($requestMakerFn, $headers, $options);
    }
}