<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;
use SGP\Validation\Helpers\Arr;

class Same implements Rule
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $message = "The :attribute value must be the same as the :other-attribute value";

    /**
     * @var string
     */
    protected $slug = 'same';

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
        $params = $this->getParams();

        return str_replace(':other-attribute', $params[0], $this->message);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        $params = $this->getParams();

        $this->requireParameterCount(1, $params, $this->getSlug());

        $otherField = $params[0];
        $otherValue = Arr::get($this->getData(), $otherField);

        return $value === $otherValue;
    }
}
