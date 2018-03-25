<?php

namespace MVI\Component\Access;

use ReflectionClass;
use ReflectionProperty;
use MVI\Component\Helpers\Arr;
use MVI\Component\Helpers\Str;
use MVI\Component\Access\SettablePropertyInterface;

/**
 *
 */
class PropertyMapper
{
    private $mapped = [];
    /**
     *
     */
    public function map(...$input)
    {
        foreach ($input as $element) {
            if (is_array($element)) {
                $key = array_keys($element);
                self::appendToMapped(
                    self::appendPrefixToArray($element[$key[0]], $key[0])
                );
            } else {
                self::appendToMapped(self::toArray($element));
            }
        }
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
    public static function appendPrefixToArray($object, $prefix)
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
