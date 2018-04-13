<?php

namespace MVI\Exception;

use MVI\Exception\MviException;

/**
 *
 */
class InvalidArgumentException extends MviException
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
