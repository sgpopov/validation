<?php

namespace Validation\Rules;

use Validation\Contracts\Rule;

class Alpha implements Rule
{
    /**
     * @var string
     */
    protected $message = "The :attribute must contains only alphabetic characters.";

    /**
     * @var string
     */
    protected $slug = 'alpha';

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
        return is_string($value) && preg_match('/^[a-zA-Z]+$/u', $value);
    }
}
