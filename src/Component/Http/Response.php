<?php

namespace MVI\Component\Http;

use MVI\Interfaces\ResponseProviderInterface;

/**
 *
 */
class Response implements ResponseProviderInterface
{
    /**
     *
     */
    private $length;
    /**
     *
     */
    private $content;
    /**
     *
     */
    private $error;
    /**
     *
     */
    private $status;
    /**
     *
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    /**
     *
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     *
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
    /**
     *
     */
    public function getError()
    {
        return $this->error;
    }
    /**
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     *
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     *
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }
    /**
     *
     */
    public function getLength()
    {
        return $this->length;
    }
}
