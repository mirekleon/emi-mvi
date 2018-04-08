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
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->assignValue($key, $value);
            }
        } else {
            $this->assignValue($name, $value);
        }
        return $this;
    }
    /**
     *
     */
    private function assignValue($name, $value)
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
