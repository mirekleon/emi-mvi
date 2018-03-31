<?php

namespace MVI\Util;

/**
 *
 */
class Str
{
    /**
     *
     */
    private static $stringConnector = '.';
    /**
     *
     */
    public static function connector($connector)
    {
        static::$stringConnector = $connector;
        return new self;
    }
    /**
     *
     */
    public static function join(...$strings)
    {
        return join(static::$stringConnector, $strings);
    }
}
