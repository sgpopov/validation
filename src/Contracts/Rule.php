<?php

namespace SGP\Validation\Contracts;

interface Rule
{
    /**
     * @return string
     */
    public function getSlug() : string;

    /**
     * @return string
     */
    public function getMessage() : string;

    /**
     * @param mixed|null $params
     *
     * @return void
     */
    public function setParams($params = null);

    /**
     * @return array
     */
    public function getParams() : array;

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool;
}
