<?php

namespace MVI\Component\Access;

/**
 *
 */
abstract class PropertyAccess
{
    /**
     *
     */
    public function set($name, $value)
    {
        $this->{$name} = $value;
        return $this;
    }
    /**
     *
     */
    public function hasProperty($name)
    {
        return property_exists($this, $name);
    }
    /**
     *
     */
    public function get($name, $default = null)
    {
        if ($this->hasProperty($name)) {
            return $this->{$name};
        }
        return $default;
    }
}
