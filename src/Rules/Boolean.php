<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Boolean implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $slug = 'boolean';

    /**
     * @var string
     */
    protected $message = "The :attribute must be able to be cast as a boolean.";

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
