<?php

namespace MVI\Exception;

use MVI\Exception\MviException;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
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
