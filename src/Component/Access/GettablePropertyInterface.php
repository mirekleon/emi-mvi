<?php

namespace MVI\Component\Access;

/**
 *
 */
interface GettablePropertyInterface
{
    /**
     *
     */
    public function get($propertyName, $defaultValue = null);
}
