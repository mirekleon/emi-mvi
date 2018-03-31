<?php

namespace MVI\Component\Http;

/**
 *
 */
class RequestMethods
{
    /**
     *
     */
    const HTTP_GET = 'GET';
    /**
     *
     */
    const HTTP_POST = 'POST';
    /**
     *
     */
    public static function hasMethod($method) : bool
    {
        $method = strtoupper($method);
        return defined('MVI\Component\Http\RequestMethods::HTTP_' . $method);
    }
}
