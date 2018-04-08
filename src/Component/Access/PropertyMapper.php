<?php

namespace MVI\Component\Access;

use MVI\Util\Arr;
use MVI\Util\Str;
use ReflectionClass;
use ReflectionProperty;
use MVI\Component\Parser\ConstantParser;
use MVI\Component\Access\SettablePropertyInterface;

/**
 *
 */
class PropertyMapper
{
    /**
     *
     */
    const INCLUDE_CONSTANT = 64;
    /**
     *
     */
    private $options = 0;
    /**
     *
     */
    private $mapped = [];
    /**
     *
     */
    public function __construct()
    {
        $this->options = array_sum(func_get_args());
    }
    /**
     *
     */
    public function map(...$input)
    {
        $input = Arr::flatten($input);
        foreach ($input as $element) {
            self::appendToMapped(self::toArray($element));
            if ($this->options >= 64) {
                if ($constants = self::getConstantsIfAny($element)) {
                    self::appendToMapped($constants);
                }
            }
        }
        return $this;
    }
    /**
     *
     */
    public static function getConstantsIfAny($object)
    {
        if (!is_object($object)) {
            return null;
        }
        $reflection = new ReflectionClass($object);
        $constants = $reflection->getConstants();

        if (!$constants) {
            return null;
        }

        $parser = new ConstantParser($reflection->getFileName());
        $found = $parser->toArray()->get();

        foreach ($constants as $name => $value) {
            /**
             * Make sure constant visibility is public
             * We must use dedicated class for this as the reflection
             * cannot determine constant visibility
             */
            if (!in_array($name, $found)) {
                unset($constants[$name]);
            }
        }

        return self::appendPrefixToArray(
            get_class_name_without_namespace($object),
            $constants
        );
    }
    /**
     *
     */
    public function mapWithPrefix($prefix, $context)
    {
        self::appendToMapped(
            self::appendPrefixToArray($prefix, $context)
        );
        return $this;
    }
    /**
     *
     */
    public function bindTo(SettablePropertyInterface $mappable)
    {
        $collapsed = Arr::collapse($this->getMapped());
        foreach ($collapsed as $key => $value) {
            $mappable->set($key, $value);
        }
        return $mappable;
    }
    /**
     *
     */
    public function getLastMapped()
    {
        return end($this->mapped);
    }
    /**
     *
     */
    public function appendToMapped(array $array)
    {
        $this->mapped[] = $array;
    }
    /**
     *
     */
    public function getMapped()
    {
        return $this->mapped;
    }
    /**
     *
     */
    public static function appendPrefixToArray($prefix, $object)
    {
        $object = static::toArray($object);
        if ($prefix) {
            foreach ($object as $key => $value) {
                $object[Str::join($prefix, $key)] = $value;
                unset($object[$key]);
            }
        }
        return $object;
    }
    /**
     *
     */
    public static function toArray($object)
    {
        return json_decode(json_encode($object), true);
    }
}
