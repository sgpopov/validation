<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Date implements Rule
{
    /**
     * @var string
     */
    protected $slug = 'date';

    /**
     * @var string
     */
    protected $message = "The :attribute is not valid date format.";

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

    /**
     * @return array
     */
    public function getParams() : array
    {
        return (array) $this->params;
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
