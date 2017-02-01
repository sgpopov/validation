<?php

namespace svil4ok\Validation\Rules;

use svil4ok\Validation\Contracts\Rule;
use svil4ok\Validation\Contracts\RuleWithArgs;

class DateBefore implements Rule, RuleWithArgs
{
    use RuleTrait;
    use DateUtilsTrait;

    /**
     * @var string
     */
    protected $slug = 'date_before';

    /**
     * @var string
     */
    protected $message = "The :attribute date must be before :date.";

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

        return str_replace(':date', $params[0], $this->message);
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
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool
    {
        $params = $this->getParams();

        $this->requireParameterCount(1, $params, $this->getSlug());

        $dateBefore = $params[0];

        if (!$this->isValidDate($value)) {
            throw new \InvalidArgumentException('Attribute value must be a valid date.');
        }

        if (!$this->isValidDate($dateBefore)) {
            throw new \InvalidArgumentException("Supplied date '{$dateBefore}' is invalid.");
        }

        return strtotime($value) < strtotime($dateBefore);
    }
}
