<?php

namespace MVI\Component\Http\Exception;

use MVI\Exception\MviException;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
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
