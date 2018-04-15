<?php

namespace MVI\Component\Container;

use Psr\Container\ContainerInterface;
use MVI\Interfaces\ContainerProviderInterface;
use MVI\Component\Container\Exception\ContainerException;
use MVI\Component\Container\Exception\ObjectNotFoundException;

/**
 *
 */
class BaseContainer implements ContainerProviderInterface, ContainerInterface
{
    /**
     * Registered classes
     */
    protected $containers = [];
    /**
     * @access public
     * Register container
     * @param String $name      - name
     * @param String $container - container to be registered
     * @return $this
     */
    public function register($name, $container)
    {
        if (!is_string($name)) {
            $this->error('Container name must be a valid string!');
        }

        if (!is_string($container)) {
            $this->error('Container path must be a valid namespace!');
        }

        if (!class_exists($container)) {
            $this->error("Class {$container} not found!");
        }

        $this->containers[$name] = $container;
        return $this;
    }
    /**
     * @access private
     * Send error
     * @param String $message - message
     * @return ContainerException
     */
    private function error($message)
    {
        throw new ContainerException($message);
    }
    /**
     * @access public
     * Check if name registered
     * @param String $name - name
     * @return Boolean
     */
    public function has($id)
    {
        return array_key_exists($id, $this->containers);
    }
    /**
     * @access public
     * Check if prefix registered
     * @param String $prefix - prefix
     * @return Boolean
     */
    public function hasPrefix($prefix)
    {
        $has = preg_grep('/' . preg_quote($prefix) . '/', array_keys($this->containers));
        return empty($has) ? false : true;
    }
    /**
     * @access public
     * Get path
     * @param String $name - name
     * @return Mixed
     */
    public function get($id)
    {
        if ($this->has($id)) {
            return new $this->containers[$id];
        }
        throw new ObjectNotFoundException("Object {$id} not found!");
    }
}
