<?php

namespace SGP\Validation\Rules;

trait RuleTrait
{
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
