<?php

namespace SGP\Validation\Rules;

trait DateUtilsTrait
{
    /**
     * Check if given string is a valid date.
     *
     * @param string|mixed $value
     *
     * @return bool
     */
    public function isValidDate($value) : bool
    {
        return (new Date)->passes($value);
    }
}
