<?php

/**
 * Extract class name from namespace
 * @param Mixed $input - input
 * @param $lowercase - lowercase result
 * @return Mixed
 */
if (!function_exists('get_class_name_without_namespace')) {
    function get_class_name_without_namespace($input, $lowercase = false)
    {
        if (is_string($input)) {
            if (strrpos($input, '\\') !== false) {
                $input = (substr($input, strrpos($input, '\\') + 1));
            }
            return ($lowercase) ? strtolower($input) : $input;
        }
        if (is_object($input)) {
            return get_class_name_without_namespace(get_class($input), $lowercase);
        }
        return null;
    }
}
/**
 * Extract method name from stack from given position
 * @param Array $backtrace - backtrace
 * @param Integer $position - backtrace position
 * @return Mixed
 */
if (!function_exists('get_method_name_from_stack')) {
    function get_method_name_from_stack(array $backtrace, $position = 0)
    {
        array_shift($backtrace);
        if (!isset($backtrace[$position])) {
            return null;
        }
        $backtrace = $backtrace[$position];
        return (isset($backtrace['function'])) ? $backtrace['function'] : null;
    }
}

/**
 * Remove new line from a string
 * @param String $string - string
 * @return String
 */
if (!function_exists('remove_new_line_from_string')) {
    function remove_new_line_from_string($string)
    {
        return preg_replace('~[\r\n]+~', '', $string);
    }
}

/**
 * Remove all whitespaces
 * @param String $string - string
 * @return String
 */
if (!function_exists('remove_whitespaces')) {
    function remove_whitespaces($string)
    {
        return preg_replace('/\s+/', '', $string);
    }
}
