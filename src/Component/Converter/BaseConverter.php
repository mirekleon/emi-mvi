<?php

namespace MVI\Component\Converter;

use Exception;
use ReflectionClass;
use MVI\Component\Converter\TypeValidator;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 *
 */
class BaseConverter
{
    /**
     * Default return value
     */
    protected $default;
    /**
     * String type
     */
    const TYPE_STRING = 'string';
    /**
     * Array type
     */
    const TYPE_ARRAY = 'array';
    /**
     * Xml type
     */
    const TYPE_XML = 'xml';
    /**
     * Json type
     */
    const TYPE_JSON = 'json';
    /**
     * @access public
     * Conver parameter into given format
     * @param Mixed    $data - data
     * @param String $format - format
     * @param Mixed $default - default value
     * @return Mixed
     */
    public function convert($data, $format, $default)
    {
        $this->default = $default;
        $format = (string) strtolower($format);
        $this->hasValidFormat($format);

        switch (getType($data)) {
            case self::TYPE_STRING:
                $type = $this->getStringType($data);
                break;
            case self::TYPE_ARRAY:
                $type = (is_array($data)) ? self::TYPE_ARRAY :  null;
                break;
            default:
                // in the case of unknown datatype see !self::TYPE_...
                return $default;
        }
        $method = $this->buildCaller($type, $format);
        return call_user_func_array([$this, $method], [$data, $default]);
    }
    /**
     * @access public
     * Check given format
     * @param String $format - format
     * @return Void | Exception
     */
    private function hasValidFormat($format)
    {
        $reflectionClass = new ReflectionClass($this);
        $constants = $reflectionClass->getConstants();
        if (!in_array($format, $constants)) {
            throw new Exception(
                sprintf('Unknown "%s" format! Available formats: [%s]', $format, join(', ', $constants))
            );
        }
    }
    /**
     * @access public
     * Get string type
     * @param String $data - string
     * @return String
     */
    public function getStringType($data)
    {
        if (!is_string($data)) {
            return null;
        }

        if (TypeValidator::isValidXml($data)) {
            return self::TYPE_XML;
        }
        if (TypeValidator::isValidJson($data)) {
            return self::TYPE_JSON;
        }
        return self::TYPE_STRING;
    }
    /**
     * @access public
     * Build method name (prefixToPostfix)
     * @param String $prefix  - before To
     * @param String $postfix - after To
     * @return String
     */
    public function buildCaller($prefix, $postfix)
    {
        return $prefix . 'To' . ucfirst(strtolower($postfix));
    }
    /**
     * @access private
     * @param String $data - data
     * @return String
     */
    private function xmlToJson($data)
    {
        $encoder = new JsonEncode();
        return $encoder->encode($this->xmlToArray($data), self::TYPE_JSON);
    }
    /**
     * @access private
     * @param String $data - data
     * @return Array
     */
    private function xmlToArray($data)
    {
        $encoder = new XmlEncoder();
        return $encoder->decode($data, self::TYPE_JSON);
    }
    /**
     * @access private
     * @param String $data - data
     * @return Array
     */
    private function jsonToArray($data)
    {
        $encoder = new JsonDecode(true);
        return $encoder->decode($data, self::TYPE_ARRAY);
    }
    /**
     * @access private
     * @param String $data - data
     * @return String
     */
    private function jsonToXml($data)
    {
        $array = $this->jsonToArray($data);
        return $this->arrayToXml($array);
    }
    /**
     * @access private
     * @param Array $data - data
     * @return String
     */
    private function arrayToXml($data)
    {
        $encoder = new XmlEncoder();
        return $encoder->encode($data, self::TYPE_XML);
    }
    /**
     * @access private
     * @param Array $data - data
     * @return String
     */
    private function arrayToJson($data)
    {
        $encoder = new JsonEncode();
        return $encoder->encode($data, self::TYPE_JSON);
    }
    /**
     * @access private
     * @param String $data - data
     * @return String
     */
    private function xmlToXml($data)
    {
        return $data;
    }
    /**
     * @access private
     * @param Array $data - data
     * @return Array
     */
    private function arrayToArray($data)
    {
        return $data;
    }
    /**
     * @access private
     * @param String $data - data
     * @return String
     */
    private function jsonToJson($data)
    {
        return $data;
    }
    /**
     * @access public
     * @param String   $method - method name
     * @param Mixed $arguments - arguments
     * @return Mixed
     */
    public function __call($method, $arguments)
    {
        return $this->default;
    }
}
