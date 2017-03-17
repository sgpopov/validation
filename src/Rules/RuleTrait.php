<?php

namespace SGP\Validation\Rules;

use SGP\Validation\Attribute;

trait RuleTrait
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @var array
     */
    protected $data;

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
     * @param Attribute $attribute
     *
     * @return void
     */
    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return Attribute
     */
    public function getAttribute() : Attribute
    {
        return $this->attribute;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data) {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * Require a certain number of parameters to be present.
     *
     * @param int $count
     * @param array $parameters
     * @param string $rule
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function requireParameterCount(int $count, array $parameters, string $rule)
    {
        if (count($parameters) < $count) {
            throw new \InvalidArgumentException("Validation rule {$rule} requires at least {$count} parameters.");
        }
    }
}
