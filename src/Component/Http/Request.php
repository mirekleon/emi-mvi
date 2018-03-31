<?php

namespace MVI\Component\Http;

use MVI\Component\Factory\Factory;
use MVI\Component\Access\PropertyMapper;
use MVI\Component\Access\PropertyAccess;
use MVI\Component\Factory\FactoryBuilder;
use MVI\Exception\InvalidArgumentException;
use MVI\Interfaces\RequestProviderInterface;
use MVI\Component\Http\Exception\RequestException;
use MVI\Component\Access\MappablePropertyInterface;
use MVI\Component\Access\SettablePropertyInterface;
use MVI\Component\Access\GettablePropertyInterface;

/**
 * This file is part of the MVI package.
 *
 * Copyright (c) Qualcomm
 */
class Request extends PropertyAccess implements
    RequestProviderInterface,
    MappablePropertyInterface,
    SettablePropertyInterface,
    GettablePropertyInterface
{
    /**
     *
     */
    protected $cache;
    /**
     *
     */
    protected $method;
    /**
     *
     */
    protected $url;
    /**
     *
     */
    protected $send;
    /**
     *
     */
    public function cache($cache)
    {
        $value = filter_var($cache, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($value === null) {
            throw new InvalidArgumentException(
                'Argument must be a valid boolean, ' . gettype($cache) . ' given!'
            );
        }
        $this->cache = (boolean) $cache;
        return $this;
    }
    /**
     *
     */
    public function method($method)
    {
        if (!RequestMethods::hasMethod($method)) {
            throw new RequestException('Unknown http request method!');
        }
        $this->method = strtoupper($method);
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
        $mapper = new PropertyMapper;
        $mapper->map($this);
        $factory = new Factory();
        $factory->set('request.cache', $this->get('cache'))
                ->set('request.method', $this->get('method'))
                ->set('request.url', $this->get('url'))
                ->set('request.data', $this->get('send'));
        $factory = $mapper->bindTo($factory);
        return $factory;
    }
}
