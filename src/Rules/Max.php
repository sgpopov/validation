<?php

namespace svil4ok\Validation\Rules;

use svil4ok\Validation\Contracts\Rule;

class Max implements Rule
{
    /**
     * @var string
     */
    protected $slug = 'max';

    /**
     * @var string
     */
    protected $message = "The :attribute maximum is :max";

    /**
     * @var mixed
     */
    protected $params;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        $params = $this->getParams();

        return str_replace(':max', $params[0], $this->message);
    }

    /**
     * @param mixed $params
     *
     * @return void
     */
    public function setParams($params = null)
    {
        $this->params = $params;
    }

    public function getParams() : array
    {
        return (array) $this->params;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        $params = $this->getParams();

        $max = $params[0];

        if (is_int($value)) {
            return $value <= $max;
        }

        if (is_string($value)) {
            return strlen($value) <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return false;
    }
}
