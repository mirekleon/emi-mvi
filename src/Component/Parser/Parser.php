<?php

namespace MVI\Component\Parser;

/**
 *
 */
abstract class Parser
{
    /**
     *
     */
    protected $content;
    /**
     *
     */
    protected $path;
    /**
     *
     */
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new Exception(sprintf('File %s not found!'), $path);
        }
        $this->path = $path;
    }
    /**
     *
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     *
     */
    public function toArray()
    {
        $this->content = file($this->getPath());
        return $this;
    }
    /**
     *
     */
    public function toString()
    {
        $this->content = file_get_contents($this->getPath());
        return $this;
    }
    /**
     *
     */
    public function getContent()
    {
        return $this->content;
    }
}
