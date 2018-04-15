<?php

namespace MVI\Component\Container\Exception;

use Exception;

/**
 *
 */
class ContainerException extends Exception
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
