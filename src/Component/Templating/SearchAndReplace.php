<?php

namespace MVI\Component\Templating;

use MVI\Exception\InvalidArgumentException;

/**
 *
 */
class SearchAndReplace
{
    /**
     * Default wrapper
     */
    const WRAPPER = '{{%s}}';
    /**
     * Wrapper
     */
    private $wrapper;
    /**
     * Replacements
     */
    private $params = [];
    /**
     * Url
     */
    private $subject;
    /**
     * Parameter is optional
     */
    const OPT_OPTIONAL = '?';
    /**
     * Default value
     */
    const OPT_DEFAULT = '|';
    /**
     * Optional parameters
     */
    private $optional = [];
    /**
     * @access public
     * Set default wrapper
     * @return Void
     */
    public function __construct()
    {
        $this->wrapper = self::WRAPPER;
    }
    /**
     * @access public
     * Set wrapper
     * @return Mixed
     */
    public function setWrapper($left, $right)
    {
        if (strlen($left) === 0 || strlen($right) === 0) {
            throw new InvalidParameterException('Wrapper cannot be empty or should have a length!');
        }
        $this->wrapper = "{$left}%s{$right}";
        return $this;
    }
    /**
     * @access public
     * Get wrapper
     * @param String $side - left/right part
     * @return String
     */
    public function getWrapper($side = null)
    {
        if ($side && $this->wrapper) {
            $side = strtolower($side);
            list($left, $right) = explode('%s', $this->wrapper);
            if ($side === 'left' || $side === 'l') {
                return $left;
            }
            if ($side === 'right' || $side === 'r') {
                return $right;
            }
        }
        return $this->wrapper;
    }
    /**
     * @access public
     * Set subject
     * @param String $subject    - subject string
     * @param Boolean $normalize - run normalizer
     * @return $this
     */
    public function setSubject($subject, $normalize)
    {
        $this->subject = ($normalize === true) ? $this->normalizeSubject($subject) : $subject;
        return $this;
    }
    /**
     * @access public
     * Check if optional value is set
     * @param String $name - key name
     * @return Boolean
     */
    public function hasOptional($name)
    {
        return isset($this->optional[$name]);
    }
    /**
     * @access public
     * Remove all optionals
     * @return $this
     */
    public function emptyOptional()
    {
        $this->optional = [];
        return $this;
    }
    /**
     * @access public
     * Get optional value
     * @param String $name - key name
     * @return Mixed
     */
    public function getOptional($name = null)
    {
        return (!$name) ? $this->optional : $this->optional[$name];
    }
    /**
     * @access protected
     * Look for optional parameters
     * @param String $subject - subject string
     * @return String
     */
    protected function normalizeSubject($subject)
    {
        $this->emptyOptional();
        list($left, $right) = explode('%s', $this->getWrapper());
        $regex = sprintf(
            '/%s([a-zA-Z]+)(%s|%s(.*?))%s/',
            $left,
            preg_quote(self::OPT_OPTIONAL),
            preg_quote(self::OPT_DEFAULT),
            $right
        );

        preg_match_all($regex, $subject, $options);
        $options = array_filter($options);
        if (empty($options)) {
            return $subject;
        }

        foreach ($options[0] as $key => $value) {
            $subject = str_replace($value, $left . $options[1][$key] . $right, $subject);
            $this->optional[$options[1][$key]] = $options[3][$key];
        }

        return $subject;
    }
    /**
     * @access public
     * Get subject
     * @return String
     */
    public function getSubject()
    {
        return $this->subject;
    }
    /**
     * @access public
     * Set replacement/parameter
     * @return $this
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
        return $this;
    }
    /**
     * @access public
     * Set replacements/parameters
     * @return $this
     */
    public function setParams($params)
    {
        if (is_array($params) && !empty($params)) {
            $params = array_merge($this->params, $params);
            $this->params = $params;
        } elseif (is_object($params)) {
            $this->setParams(json_decode(json_encode($params), true));
        }
        return $this;
    }
    /**
     * @access public
     * Get replacemnets
     * @return Array
     */
    public function getParams()
    {
        return $this->params;
    }
    /**
     * @access public
     * Build subject
     * @return String
     */
    public function build()
    {
        if ($params = $this->getParams()) {
            foreach ($params as $key => $value) {
                if (is_string($value)) {
                    $key = sprintf($this->getWrapper(), $key);
                    if (strrpos($this->getSubject(), $key) !== false) {
                        $this->setSubject(str_replace($key, $value, $this->getSubject()), false);
                    }
                }
            }
        }

        // search for the optional parameters
        $optionals = $this->getOptional();
        if (count($optionals)) {
            foreach ($optionals as $key => $value) {
                $this->setParam($key, $value);
            }
            $this->emptyOptional()->build();
        }

        return $this->getSubject();
    }
    /**
     * @access public
     * Set replacement property
     * @param String $param - key name
     * @param String $argument - value
     * @return $this
     */
    public function __call($param, $argument)
    {
        $value = isset($argument[0]) ? $argument[0] : '';
        $this->setParam($param, $value);
        return $this;
    }
}
