<?php

namespace MVI\Component\Http;

use MVI\Component\Factory\FactoryBuilder;
use MVI\Interfaces\RequestProviderInterface;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
 */
class Request implements RequestProviderInterface
{
    /**
     *
     */
    protected $cache;
    protected $method;
    protected $url;
    protected $send;
    protected $factory;
    /**
     *
     */
    public function cache($cache)
    {
        $this->cache = $cache;
        return $this;
    }
    /**
     *
     */
    public function method($method)
    {
        $this->method = $method;
        return $this;
    }
    /**
     *
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     *
     */
    public function send($send)
    {
        $this->send = $send;
        return $this;
    }
    /**
     *
     */
    public function make()
    {
        return $this;
    }
    /**
     *
     */
    public function set($name, $value)
    {
        return $this->{$name};
    }
    /**
     *
     */
    public function get($name)
    {
        return $this->{$name};
    }
}
