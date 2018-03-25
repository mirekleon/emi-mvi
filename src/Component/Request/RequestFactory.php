<?php

namespace MVI\Component\Request;

use MVI\Component\Request\RequestMethods;
use MVI\Component\Access\MappablePropertyInterface;

/**
 *
 */
class RequestFactory implements MappablePropertyInterface
{
    /**
     *
     */
    public $cache = true;
    /**
     *
     */
    public $url = null;
    /**
     *
     */
    public $body = [];
    /**
     *
     */
    public $method = RequestMethods::HTTP_GET;
    /**
     *
     */
    public function setMethod($method)
    {
        if (!RequestMethods::hasMethod($method)) {
            throw new \Exception('Unknown http request method!');
        }
        $this->method = strtoupper($method);
        return $this;
    }
    /**
     *
     */
    public function getMethod() : string
    {
        return $this->method;
    }
    /**
     *
     */
    public function setCache($cache)
    {
        $value = filter_var($cache, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($value === null) {
            throw new \Exception('Argument must be a valid boolean, ' . gettype($cache) . ' given!');
        }
        $this->cache = (boolean) $cache;
        return $this;
    }
    /**
     *
     */
    public function getCache() : bool
    {
        return $this->cache;
    }
    /**
     *
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     *
     */
    public function getUrl() : string
    {
        return $this->url;
    }
    /**
     *
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    /**
     *
     */
    public function getBody()
    {
        return $this->body;
    }
    /**
     *
     */
    public function sendRequest($callback)
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, [$this]);
        }
        throw new \Exception('Argument must be callable, ' . gettype($callback) . ' given!');
    }
}
