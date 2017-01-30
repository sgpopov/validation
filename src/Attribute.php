<?php

namespace svil4ok\Validator;

//use svil4ok\Validator\Contracts\Rule;

use svil4ok\Validator\Contracts\Rule;

class Attribute
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $key;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @var null
     */
    protected $primaryAttribute = null;

    /**
     * Attribute constructor.

     * @param string $attribute
     * @param array $rules
     * @param bool $required
     */
    public function __construct($attribute, array $rules = [], bool $required = false)
    {
        $this->key = $attribute;
        $this->required = $required;

        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    /**
     * @param Rule $rule
     *
     * @return void
     */
    public function addRule(Rule $rule)
    {
        $this->rules[$rule->getSlug()] = $rule;
    }

    /**
     * @param $ruleKey
     *
     * @return mixed|null
     */
    public function getRule($ruleKey)
    {
        return $this->hasRule($ruleKey) ? $this->rules[$ruleKey] : null;
    }

    /**
     * @return array
     */
    public function getRules() : array
    {
        return $this->rules;
    }

    /**
     * @param $ruleKey
     *
     * @return bool
     */
    public function hasRule($ruleKey) : bool
    {
        return isset($this->rules[$ruleKey]);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }
}
