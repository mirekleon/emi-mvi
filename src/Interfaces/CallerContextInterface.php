<?php

namespace MVI\Interfaces;

use MVI\Component\Access\MappablePropertyInterface;

/**
 *
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
