<?php

namespace MVI\Component\Request;

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
        return defined('MVI\Component\Request\RequestMethods::HTTP_' . $method);
    }
}
