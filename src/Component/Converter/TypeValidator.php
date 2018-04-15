<?php

namespace MVI\Component\Converter;

use DOMDocument;

/**
 *
 */
class TypeValidator
{
    /**
     * @access public static
     * Check if a parameter is a valid XML string
     * @param Mixed $data - parameter
     * @return Boolean
     */
    public static function isValidXml($data)
    {
        if (!is_string($data)) {
            return false;
        }
        if (!strlen(preg_replace('/[\r\n]+/', '', $data))) {
            return false;
        }
        /**
         * don't use native symfony validator
         */
        libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML($data);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }
    /**
     * @access public static
     * Check if a parameter is a valid JSON string
     * @param Mixed $data - parameter
     * @return Boolean
     */
    public static function isValidJson($string)
    {
        if (!is_string($string)) {
            return false;
        }

        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
