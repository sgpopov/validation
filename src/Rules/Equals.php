<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;

class Equals implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute must be equal to :value.";

    /**
     * @var string
     */
    protected $slug = 'equals';

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
        $this->requireParameterCount(1, $this->getParams(), $this->getSlug());

        $expectedValue = $this->getParams()[0];

        return $value === $expectedValue;
    }
}
