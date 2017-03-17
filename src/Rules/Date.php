<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Date implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $slug = 'date';

    /**
     * @var string
     */
    protected $message = "The :attribute is not valid date format.";

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
     * Validate that an attribute value is a valid date.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        if (strtotime($value) === false) {
            return false;
        }

        $date = date_parse($value);

        return checkdate($date['month'], $date['day'], $date['year']);
    }
}
