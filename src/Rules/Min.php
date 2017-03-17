<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;
use SGP\Validation\Contracts\RuleWithArgs;

class Min implements Rule, RuleWithArgs
{
    use RuleTrait;

    /**
     * @var string
     */
    protected $slug = 'min';

    /**
     * @var string
     */
    protected $message = "The :attribute minimum is :min";

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
        $params = $this->getParams();

        return str_replace(':min', $params[0], $this->message);
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

    public function getParams() : array
    {
        return (array) $this->params;
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

        $min = $params[0];

        if (is_int($value)) {
            return $value >= $min;
        }

        if (is_string($value)) {
            return strlen($value) >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return false;
    }
}
