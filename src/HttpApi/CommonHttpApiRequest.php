<?php

namespace MagpieLib\Interops\HttpApi;

use Exception;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\Facades\Http\Exceptions\ClientException;
use Magpie\Facades\Http\HttpClientPendingRequest;
use Magpie\Facades\Http\HttpClientResponse;
use Magpie\General\Names\CommonHttpStatusCode;
use Magpie\General\Traits\StaticCreatable;
use MagpieLib\Interops\Exceptions\BadHttpStatusResponseHardInteropsException;
use MagpieLib\Interops\Exceptions\CommonInteropsException;
use MagpieLib\Interops\Exceptions\InternalHardInteropsException;
use MagpieLib\Interops\Exceptions\NetworkErrorHardInteropsException;

/**
 * Basics for HTTP based request
 */
abstract class CommonHttpApiRequest
{
    use StaticCreatable;

    /**
     * @var bool If bad HTTP status code will be rejected
     */
    protected bool $isRejectBadHttpStatusCode = true;


    /**
     * Run the HTTP request
     * @param callable():HttpClientPendingRequest $requestMakerFn
     * @param iterable $headers
     * @param iterable $options
     * @return HttpClientResponse
     * @throws SafetyCommonException
     * @throws CommonInteropsException
     */
    protected function runRequest(callable $requestMakerFn, iterable $headers, iterable $options) : HttpClientResponse
    {
        try {
            $request = $requestMakerFn();

            foreach ($headers as $headerKey => $headerValue) {
                $request->withHeader($headerKey, $headerValue);
            }
            foreach ($options as $option) {
                $request->withOption($option);
            }
            $response = $request->request();

            if ($this->isRejectBadHttpStatusCode && !CommonHttpStatusCode::isSuccessful($response->getHttpStatusCode())) {
                throw new BadHttpStatusResponseHardInteropsException($response->getHttpStatusCode());
            }
            return $response;
        } catch (CommonInteropsException $ex) {
            throw $ex;
        } catch (ClientException $ex) {
            throw new NetworkErrorHardInteropsException(previous: $ex);
        } catch (Exception $ex) {
            throw new InternalHardInteropsException(previous: $ex);
        }
    }


    /**
     * Specify if bad HTTP status code will be rejected
     * @param bool $isRejectBadHttpStatusCode
     * @return $this
     */
    public function withRejectBadHttpStatusCode(bool $isRejectBadHttpStatusCode) : static
    {
        $this->isRejectBadHttpStatusCode = $isRejectBadHttpStatusCode;
        return $this;
    }
}