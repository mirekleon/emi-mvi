<?php

namespace MVI\Component\Payload;

use ReflectionObject;
use ReflectionProperty;
use MVI\Component\Converter\Converter;

/**
 *
 */
class PayloadBuilder
{
    /**
     * default RPC template
     */
    private $template = '{
        "jsonrpc": "2.0",
        "method": "{{method|get}}",
        "id": "{{id}}",
        "params": [{"url":"{{url}}"}],
        "session": "{{session}}"
    }';
    /**
     * Members to remove
     */
    private $remove = [];
    /**
     * Payload parameters
     */
    private $params = [];
    /**
     * Payload
     */
    private $payload = '';
    /**
     * User payload
     */
    private $rawPayload = null;
    /**
     * @access public
     * Set raw payload
     * @param Mixed $raw - raw payload
     * @return $this
     */
    public function raw($raw)
    {
        if (is_string($raw)) {
            $raw = Converter::toArray($raw);
        }
        $this->rawPayload = $raw;
        return $this;
    }
    /**
     * @access public
     * Set top level payload member
     * @param String $member - name
     * @param Mixed $value   - value
     * @return $this
     */
    public function set($member, $value)
    {
        $this->{$member} = $value;
        return $this;
    }
    /**
     * @access public
     * Remove member(s)
     * @param String $member - name
     * @return $this
     */
    public function remove($member)
    {
        $members = is_array($member) ? $member : func_get_args();
        $this->remove = (empty($this->remove)) ? $members : $this->remove + $members;
        return $this;
    }
    /**
     * @access public
     * Add parameter member
     * @param String $param - key
     * @param Mixed $value  - value
     * @return $this
     */
    public function addParam($param, $value)
    {
        $this->params[$param] = $value;
        return $this;
    }
    /**
     * @access public
     * Get default template
     * @return String
     */
    public function getDefaultTemplate()
    {
        return remove_whitespaces($this->template);
    }
    /**
     * @access public
     * Get raw input
     * @return String
     */
    public function getRaw()
    {
        return Converter::toJson($this->rawPayload);
    }
    /**
     * @access public
     * Get payload
     * @param String $jsonFormat - format (array|json)
     * @return Mixed
     */
    public function get($jsonFormat = true)
    {
        return $jsonFormat === true ? Converter::toJson($this->payload) : $this->payload;
    }
    /**
     * @access public
     * Combine given elements (raw, template, members, parameters)
     * @return $this
     */
    public function build()
    {
        $template = (array) Converter::toArray($this->template);

        $this->payload = (!$this->rawPayload)
            ? $template
            : $this->rawPayload;

        // compare raw input with template to find missing members
        $diff = array_diff(array_keys($template), array_keys($this->payload));
        // get all public class members
        $members = $this->getMembers();
        // there was not extra template but some of the mebers were set
        if (empty($diff) && count($members) > 0) {
            $diff = $members;
        }
        // set has priority over raw template member
        $priority = array_diff($members, $diff);

        if ($priority) {
            $diff = array_merge($diff, $priority);
        }

        if ($diff) {
            foreach ($diff as $element) {
                $this->payload[$element] = !in_array($element, $members)
                    ? $template[$element]
                    : $this->{$element};
            }
        }

        if (isset($this->payload['params'][0])) {
            $this->payload['params'][0] = array_merge($this->payload['params'][0], $this->params);
        }

        if (!empty($this->remove)) {
            foreach ($this->remove as $element) {
                unset($this->payload[$element]);
            }
        }

        return $this;
    }
    /**
     * @access public
     * Get all public vars
     * @return Array
     */
    private function getMembers()
    {
        $reflection = new ReflectionObject($this);
        return array_map(function ($member) {
            return $member->getName();
        }, $reflection->getProperties(ReflectionProperty::IS_PUBLIC));
    }
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->get();
    }
}
