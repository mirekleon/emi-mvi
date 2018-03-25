<?php

namespace MVI\Component\Dispatcher;

use MVI\Component\Response\Response;
use MVI\Component\Dispatcher\Factory;
use MVI\Component\Access\PropertyMapper;
use MVI\Component\Request\RequestFactory;

/**
 *
 */
class Request
{
    /**
     *
     */
    private $bindFactory;
    /**
     *
     */
    private $requestFactory;
    /**
     *
     */
    public function __construct()
    {
        $this->initDefaults();
    }
    /**
     *
     */
    public function initDefaults()
    {
        $this->requestFactory = new RequestFactory;
        $this->bindFactory = new BindFactory;
    }
    /**
     *
     */
    public function cache($cache)
    {
        $this->requestFactory->setCache($cache);
        return $this;
    }
    /**
     *
     */
    public function method($method)
    {
        $this->requestFactory->setMethod($method);
        return $this;
    }
    /**
     *
     */
    public function url($url)
    {
        $this->requestFactory->setUrl($url);
        return $this;
    }
    /**
     *
     */
    public function send($data)
    {
        $this->requestFactory->setBody($data);
        return $this;
    }
    /**
     *
     */
    public function make()
    {
        $mapper = new PropertyMapper;
        $mapper->map(
            $this->bindFactory,
            ['request' => $this->requestFactory]
        );
        $factory = new Factory();
        $factory = $mapper->bindTo($factory);
        $this->initDefaults();
        return $factory;
    }
    /**
     *
     */
    public function set($name, $value)
    {
        $this->bindFactory->set($name, $value);
        return $this;
    }
    /**
     *
     */
    public function bind(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
        return $this;
    }
}
