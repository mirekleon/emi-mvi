<?php

namespace MVI\Component\Bridge;

use MVI\Util\StringBuilder;
use MVI\Component\Bridge\Collector;
use MVI\Component\Notation\Notation;
use MVI\Component\Interceptor\Interceptor;
use MVI\Component\Container\BaseContainer;
use MVI\Component\Bridge\InterceptorBridge;
use MVI\Component\Bridge\Exception\UnknownInstanceException;
use MVI\Component\Bridge\Exception\MethodNotCallableException;

/**
 *
 */
class MultiVendorBridge
{
    /**
     * BaseContainer Instance
     */
    protected $container = null;
    /**
     * Interceptor Instance
     */
    protected $interceptor = null;
    /**
     * Result collection
     */
    protected $collection = [];
    /**
     * @access public
     * Set defaults
     * @param BaseContainer $container - container
     * @return Void
     */
    public function __construct(BaseContainer $container)
    {
        $this->collector = new Collector;
        $this->container = $container;
        $this->collector->set('action', 'read');
    }
    /**
     * @access public
     * Set key
     * @param String $key - key
     * @return $this
     */
    public function key($key)
    {
        $this->collector->set('key', $key);
        return $this;
    }
    /**
     * @access public
     * Set host and key
     * @param String $host - hostname
     * @param String $key  - key
     * @return $this
     */
    public function host($host, $key = null)
    {
        $this->collector->set('host', $host);
        if ($key) {
            $this->collector->set('key', $key);
        }
        return $this;
    }
    /**
     * @access public
     * Set action
     * @param String $action - action
     * @return $this
     */
    public function action($action)
    {
        $this->collector->set('action', $action);
        return $this;
    }
    /**
     * @access public
     * Set vendor
     * @param String $vendor - vendor
     * @return $this
     */
    public function vendor($vendor)
    {
        $this->collector->set('vendor', $vendor);
        return $this;
    }
    /**
     * @access public
     * Call final method
     * @param String $name - object / method name
     * @param Array $parameters - parameters
     * @return $this
     */
    public function call($name, ...$parameters)
    {
        return $this;
    }
}
