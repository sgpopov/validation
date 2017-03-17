<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class IsArray implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute must be an array.";

    /**
     * @var string
     */
    protected $slug = 'array';

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
        return is_array($value);
    }
}
