<?php

namespace MVI\Component\Bridge\Exception;

use MVI\Exception\MviException;

/**
 *
 */
class UnknownInstanceException extends MviException
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
