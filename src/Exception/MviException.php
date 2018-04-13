<?php

namespace MVI\Exception;

use Exception;

/**
 *
 */
class MviException extends Exception
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
