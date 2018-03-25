<?php

namespace MVI\Component\Access;

use ReflectionObject;
use ReflectionProperty;
use MVI\Component\Access\Factory;

/**
 *
 */
trait PropertyAccessTrait
{
    /**
     *
     */
    public function getAll() : Factory
    {
        $reflectionObject = new ReflectionObject($this);
        $properties = $reflectionObject->getProperties(
            ReflectionProperty::IS_PUBLIC
        );

        if (empty($properties)) {
            return null;
        }

        $propertyFactory = new Factory;
        foreach ($properties as $property) {
            $propertyFactory->set($property->name, $this->{$property->name});
        }
        return $propertyFactory;
    }
    /**
     *
     */
    public function __call($method, $args)
    {
        $type = substr($method, 0, 3);
        $name = substr($method, 3);

        if ($type === 'get') {
            $args = $args[0] ?? null;
            return call_user_func_array([$this, $type], [$name, $args]);
        }

        if ($type === 'set' && method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $args);
        }

        throw new \Exception('Method not implemented');
    }
}
