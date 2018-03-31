<?php

namespace MVI\Exception;

use Exception;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
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
