<?php

namespace MVI\Component\Container\Exception;

use MVI\Component\Container\Exception\ContainerException;

/**
 *
 */
class ObjectNotFoundException extends ContainerException
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
