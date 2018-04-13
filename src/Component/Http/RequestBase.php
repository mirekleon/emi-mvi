<?php

namespace MVI\Component\Http;

use MVI\Component\Http\Response;
use MVI\Component\Factory\Factory;
use MVI\Component\Access\PropertyMapper;
use MVI\Component\Access\PropertyAccess;
use MVI\Interfaces\CallerContextInterface;
use MVI\Interfaces\RequestProviderInterface;
use MVI\Component\Access\MappablePropertyInterface;
use MVI\Component\Access\SettablePropertyInterface;
use MVI\Component\Access\GettablePropertyInterface;

/**
 *
 */
class RequestBase extends PropertyAccess implements
    CallerContextInterface,
    RequestProviderInterface,
    MappablePropertyInterface,
    SettablePropertyInterface,
    GettablePropertyInterface
{
    /**
     *
     */
    private $context;
    /**
     *
     */
    public function setContext(MappablePropertyInterface $context)
    {
        $this->context = $context;
    }
    /**
     *
     */
    public function getContext() : MappablePropertyInterface
    {
        return $this->context;
    }
    /**
     *
     */
    public function make()
    {
        $context = $this->getContext();
        $mapper = new PropertyMapper(PropertyMapper::INCLUDE_CONSTANT);
        $mapper->map($this, $context);
        $factory = new Factory();
        $factory->set([
            'request.cache'    => $this->requestCache,
            'request.headers'  => $this->requestHeaders,
            'request.method'   => $this->requestMethod,
            'request.url'      => $this->requestUrl,
            'request.data'     => $this->requestData,
            'mvi.version'      => $context->getMultiVendorVersion(),
            'mvi.class'        => $context->getMultiVendorCallerClass(),
            'mvi.method'       => $context->getMultiVendorCallerMethod(),
            'workers.response' => new Response
        ]);
        $mapper->bindTo($factory);
        return $factory;
    }
}
