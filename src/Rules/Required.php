<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Required implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute is required";

    /**
     * @var string
     */
    protected $slug = 'required';

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
        if (is_string($value)) {
            return strlen(trim($value)) > 0;
        }

        if (is_array($value)) {
            return count($value) > 0;
        }

        return !is_null($value);
    }
}
