<?php

namespace MVI\Component\Dispatcher;

use MVI\Component\Access\MappablePropertyInterface;

/**
 *
 */
class BindFactory extends \MVI\Component\Access\PropertyAccess implements MappablePropertyInterface
{
    /**
     *
     */
    public function set($name, $value)
    {
        if (!is_string($name)) {
            throw new \Exception('Argument must be a valid string, ' . gettype($name) . ' given!');
        }
        $this->{$name} = $value;
    }
}
