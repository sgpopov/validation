<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Contracts\Rule;
use SGP\Validation\Contracts\RuleWithArgs;

class DateAfter implements Rule, RuleWithArgs
{
    use RuleTrait;
    use DateUtilsTrait;

    /**
     * @var string
     */
    protected $slug = 'date_after';

    /**
     * @var string
     */
    protected $message = "The :attribute date must be after :date.";

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

        return str_replace(':date', $params[0], $this->message);
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

        $dateAfter = $params[0];

        if (!$this->isValidDate($value)) {
            throw new \InvalidArgumentException('Attribute value must be a valid date.');
        }

        if (!$this->isValidDate($dateAfter)) {
            throw new \InvalidArgumentException("Supplied date '{$dateAfter}' is invalid.");
        }

        return strtotime($value) > strtotime($dateAfter);
    }
}
