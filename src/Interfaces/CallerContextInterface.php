<?php

namespace MVI\Interfaces;

use MVI\Component\Access\MappablePropertyInterface;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
 */
interface CallerContextInterface
{
    /**
     *
     */
    public function setContext(MappablePropertyInterface $context);
    /**
     *
     */
    public function getContext() : MappablePropertyInterface;
}
