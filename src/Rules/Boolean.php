<?php

namespace Validation\Rules;

use Validation\Contracts\Rule;

class Boolean implements Rule
{
    /**
     * @var string
     */
    protected $slug = 'boolean';

    /**
     * @var string
     */
    protected $message = "The :attribute must be able to be cast as a boolean.";

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
     * Validate that an attribute is a boolean: true, false, 1, 0, '1', '0'.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        return in_array($value, [true, false, 1, 0, '1', '0'], true);
    }
}
