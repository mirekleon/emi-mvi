<?php

namespace MVI\Component\Http\Exception;

use MVI\Exception\MviException;

/**
 *
 */
class RequestException extends MviException
{
    /**
     *
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
