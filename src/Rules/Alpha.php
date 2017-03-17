<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Alpha implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute must contains only alphabetic characters.";

    /**
     * @var string
     */
    protected $slug = 'alpha';

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
        return is_string($value) && preg_match('/^[a-zA-Z]+$/u', $value);
    }
}
