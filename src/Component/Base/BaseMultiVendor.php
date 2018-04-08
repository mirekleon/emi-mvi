<?php

namespace MVI\Component\Base;

use MVI\Exception\MviException;
use MVI\Interfaces\RequestProviderInterface;
use MVI\Interfaces\ResponseProviderInterface;
use MVI\Interfaces\ContainerProviderInterface;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
 */
abstract class BaseMultiVendor
{
    /**
     * Mvi Version
     */
    private const VERSION = 'v3.0.0';
    /**
     * ContainerProviderInterface
     */
    private $multiVendorContainer;
    /**
     * ResponseProviderInterface
     */
    private $multiVendorResponse;
    /**
     * RequestProviderInterface
     */
    private $multiVendorRequest;
    /**
     * Class name
     */
    private $multiVendorCallerClass;
    /**
     * Method name
     */
    private $multiVendorCallerMethod;
    /**
     * @access public
     * Set defaults
     * @return Void
     */
    public function __construct()
    {
        $this->setMultiVendorCallerClass(
            get_class_name_without_namespace(get_called_class())
        );
    }
    /**
     * @access protected
     * Set class name
     * @param String $name - class name
     * @return Void
     */
    protected function setMultiVendorCallerClass($name)
    {
        $this->multiVendorCallerClass = $name;
    }
    /**
     * @access public
     * Get class name
     * @return String
     */
    public function getMultiVendorCallerClass()
    {
        return $this->multiVendorCallerClass;
    }
    /**
     * @access protected
     * Set method name
     * @param String $name - method name
     * @return Void
     */
    protected function setMultiVendorCallerMethod($name)
    {
        $this->multiVendorCallerMethod = $name;
    }
    /**
     * @access public
     * Get method name
     * @return String
     */
    public function getMultiVendorCallerMethod()
    {
        return $this->multiVendorCallerMethod;
    }
    /**
     * @access public
     * Add ContainerProviderInterface
     * @param ContainerProviderInterface $container - container
     * @return Void
     */
    public function setMultiVendorContainer(ContainerProviderInterface $container)
    {
        $this->multiVendorContainer = $container;
    }
    /**
     * @access public
     * Get ContainerProviderInterface
     * @return ContainerProviderInterface
     */
    public function getMultiVendorContainer()
    {
        return $this->multiVendorContainer;
    }
    /**
     * @access public
     * Add RequestProviderInterface
     * @param RequestProviderInterface $request
     * @return Void
     */
    public function setMultiVendorRequest(RequestProviderInterface $request)
    {
        $this->multiVendorRequest = $request;
    }
    /**
     * @access public
     * Get RequestProviderInterface
     * @return Mixed
     */
    public function getMultiVendorRequest($recreate = false)
    {
        if (!$this->multiVendorRequest instanceof RequestProviderInterface) {
            throw new MviException(
                'RequestProviderInterface instance not found!'
            );
        }
        return ($recreate === true) ? new $this->multiVendorRequest : $this->multiVendorRequest;
    }
    /**
     * @access public
     * Add ResponseProviderInterface
     * @param ResponseProviderInterface $response
     * @return Void
     */
    public function setMultiVendorResponse(ResponseProviderInterface $response)
    {
        $this->multiVendorResponse = $response;
    }
    /**
     * @access public
     * Get ResponseProviderInterface
     * @return Mixed
     */
    public function getMultiVendorResponse($recreate = false)
    {
        if (!$this->multiVendorResponse instanceof ResponseProviderInterface) {
            throw new MviException(
                'ResponseProviderInterface instance not found!'
            );
        }
        return ($recreate === true) ? new $this->multiVendorResponse : $this->multiVendorResponse;
    }
    /**
     * @access public
     * {@inheritdoc}
     */
    public function __toString()
    {
        return get_called_class();
    }
    /**
     * @access public
     * Get VERSION
     * @return self::VERSION
     */
    public function getMultiVendorVersion()
    {
        return self::VERSION;
    }
}
