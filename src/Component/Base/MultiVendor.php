<?php

namespace MVI\Component\Base;

use MVI\Component\Base\BaseMultiVendor;
use MVI\Component\Access\MappablePropertyInterface;

/**
 *
 */
abstract class MultiVendor extends BaseMultiVendor implements MappablePropertyInterface
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
        $request = parent::getMultiVendorRequest(true);
        $request->setContext($this);
        return $request;
    }
    /**
     * @access protected
     * Invoke response class
     * This method is invoked via MagicTrait
     * @return ResponseProviderInterface
     */
    protected function response()
    {
        $response = parent::getMultiVendorResponse(true);
        $response->setContext($this);
        return $response;
    }
}
