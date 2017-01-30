<?php

namespace svil4ok\Validator;

class RulesParser
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * RulesParser constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Parse the human-friendly rules into a full rules array for the validator.
     *
     * @param array|string $rules
     *
     * @return array
     */
    public function resolve($rules) : array
    {
        $resolved = [];

        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        foreach ($rules as $idx => $rule) {
            if (empty($rule)) {
                continue;
            }

            if (is_string($rule)) {
                list($rulename, $params) = $this->parseRule($rule);

                $validator = call_user_func_array(
                    $this->getValidator(), array_merge([$rulename], $params)
                );

                $resolved[] = $validator;
            }
        }

        return $resolved;
    }

    /**
     * Extract the rule name and parameters from a rule.
     *
     * @param string $rule
     *
     * @return array
     */
    protected function parseRule(string $rule) : array
    {
        $split = explode(':', $rule, 2);

        $rulename = $split[0];

        $params = isset($split[1]) ? explode(',', $split[1]) : [];

        return [$rulename, $params];
    }

    /**
     * @return Validator
     */
    protected function getValidator() : Validator
    {
        return $this->validator;
    }
}