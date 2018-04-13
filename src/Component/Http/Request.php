<?php

namespace MVI\Component\Http;

use MVI\Component\Factory\Factory;
use MVI\Component\Http\RequestBase;
use MVI\Component\Http\RequestMethods;
use MVI\Component\Access\PropertyMapper;
use MVI\Exception\InvalidArgumentException;
use MVI\Component\Http\Exception\RequestException;

/**
 *
 */
class Request extends RequestBase
{
    /**
     *
     */
    protected $requestHeaders;
    /**
     *
     */
    protected $requestCache;
    /**
     *
     */
    protected $requestMethod;
    /**
     *
     */
    protected $requestUrl;
    /**
     *
     */
    protected $requestData;
    /**
     *
     */
    public function cache($cache)
    {
        $value = filter_var($cache, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (null === $value) {
            throw new InvalidArgumentException(
                'Argument must be a valid boolean, ' . gettype($cache) . ' given!'
            );
        }
        $this->requestCache = (boolean) $cache;
        return $this;
    }
    /**
     *
     */
    public function method($method)
    {
        if (!RequestMethods::hasMethod($method)) {
            throw new RequestException('Unknown http request method!');
        }
        $this->requestMethod = strtoupper($method);
        return $this;
    }
    /**
     *
     */
    public function headers(array $headers)
    {
        $this->requestHeaders = $headers;
        return $this;
    }
    /**
     *
     */
    public function url($url)
    {
        $this->requestUrl = $url;
        return $this;
    }
    /**
     *
     */
    public function send($data)
    {
        $this->requestData = $data;
        return $this;
    }
    /**
     *
     */
    public function make()
    {
        return parent::make();
    }
}
