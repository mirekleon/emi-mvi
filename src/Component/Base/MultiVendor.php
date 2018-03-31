<?php

namespace MVI\Component\Base;

use MVI\Component\Base\BaseMultiVendor;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
 */
abstract class MultiVendor extends BaseMultiVendor
{
    /**
     * __get magic method
     */
    use MagicTrait;
    /**
     * Request instance
     */
    private $request;
    /**
     * Response instance
     */
    private $response;
    /**
     * @access protected
     * Invoke request class
     * This method is invoked via MagicTrait
     * @return RequestProviderInterface
     */
    protected function request()
    {
        return parent::getMultiVendorRequest();
    }
    /**
     * @access protected
     * Invoke response class
     * This method is invoked via MagicTrait
     * @return ResponseProviderInterface
     */
    protected function response()
    {
        return parent::getMultiVendorResponse();
    }
}
