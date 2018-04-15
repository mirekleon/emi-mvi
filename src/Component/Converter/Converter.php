<?php

namespace MVI\Component\Converter;

use MVI\Component\Converter\BaseConverter;

/**
 *
 */
class Converter
{
    /**
     * @access public static
     * Convert to Json
     * @param Mixed            $data - data
     * @param String | null $default - default value
     * @return Mixed
     */
    public static function toJson($data, $default = null)
    {
        $serializer = new BaseConverter();
        return $serializer->convert($data, 'json', $default);
    }
    /**
     * @access public static
     * Convert to Array
     * @param Mixed    $data - data
     * @param Array $default - default value
     * @return Mixed
     */
    public static function toArray($data, $default = [])
    {
        $serializer = new BaseConverter();
        return $serializer->convert($data, 'array', $default);
    }
    /**
     * @access public static
     * Convert to Xml
     * @param Mixed            $data - data
     * @param String | null $default - default value
     * @return Mixed
     */
    public static function toXml($data, $default = null)
    {
        $serializer = new BaseConverter();
        return $serializer->convert($data, 'xml', $default);
    }
}
