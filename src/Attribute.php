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
     */
    public function __construct($attribute, array $rules = [])
    {
        $this->key = $attribute;

        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function addRule(Rule $rule)
    {
//        $rule->setAttribute($this);
//        $rule->setValidation($this->validation);

        $this->rules[$rule->getSlug()] = $rule;
    }

    public function getRule($ruleKey)
    {
        return $this->hasRule($ruleKey) ? $this->rules[$ruleKey] : null;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function hasRule($ruleKey)
    {
        return isset($this->rules[$ruleKey]);
    }

    public function getKey()
    {
        return $this->key;
    }
}