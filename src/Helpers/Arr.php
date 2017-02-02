<?php

namespace svil4ok\Validation\Helpers;

class Arr
{
    /**
     * Get array key data.
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function get(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $default ?: $array;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        $segments = explode('.', $key);

        foreach ($segments as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default ?: $array;
            }
        }

        return $array;
    }

    /**
     * Set an item on an array or object using dot notation.
     *
     * @param mixed $array
     * @param string|array $key
     * @param mixed $value
     * @param bool $overwrite
     *
     * @return array
     */
    public static function set($array, $key, $value, $overwrite = false) : array
    {
        if (!is_array($array)) {
            $array = [];
        }

        $segments = is_array($key) ? $key : explode('.', $key);

        if (($segment = array_shift($segments)) === '*') {
            if ($segments) {
                foreach ($array as &$inner) {
                    static::set($inner, $segments, $value, $overwrite);
                }
            } else if ($overwrite) {
                $array = array_map(function () use ($value) {
                    return $value;
                }, $array);
            }
        } else {
            if ($segments) {
                if (!array_key_exists($segment, $array)) {
                    $array[$segment] = [];
                }

                static::set($array[$segment], $segments, $value, $overwrite);
            } else if ($overwrite || !array_key_exists($segment, $array)) {
                $array[$segment] = $value;
            }
        }

        return $array;
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array $array
     * @param string $prepend
     *
     * @return array
     */
    public static function dot(array $array, $prepend = '') : array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }
}
