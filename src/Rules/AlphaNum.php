<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class AlphaNum implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute must contains only alpha-numeric characters.";

    /**
     * @var string
     */
    protected $slug = 'alpha_num';

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
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\pL\pM\pN_-]+$/u', $value) > 0;
    }
}
