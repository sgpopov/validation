<?php

namespace Validation\Rules;

use Validation\Contracts\Rule;

class Numeric implements Rule
{
    /**
     * @var string
     */
    protected $message = "The :attribute must be numeric.";

    /**
     * @var string
     */
    protected $slug = 'numeric';

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
        return $this->message;
    }

    /**
     * @param mixed|null $params
     */
    public function setParams($params = null)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
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
        return is_numeric($value);
    }
}
