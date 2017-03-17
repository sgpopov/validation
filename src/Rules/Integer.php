<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Integer implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute must be integer.";

    /**
     * @var string
     */
    protected $slug = 'int';

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
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        return is_numeric($value) && filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
}
