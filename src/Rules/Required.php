<?php

namespace svil4ok\Validator\Rules;

use svil4ok\Validator\Contracts\Rule;

class Required implements Rule
{
    /**
     * @var string
     */
    protected $message = "The :attribute is required";

    /**
     * @var string
     */
    protected $slug = 'required';

    /**
     * @var mixed
     */
    protected $params;

    /**
     * @return string
     */
    public function getSlug() : string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @param mixed|null $params
     */
    public function setParams($params = null)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
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
        if (is_string($value)) {
            return strlen(trim($value)) > 0;
        }

        if (is_array($value)) {
            return count($value) > 0;
        }

        return !is_null($value);
    }
}