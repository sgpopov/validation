<?php

namespace SGP\Validation\Contracts;

use SGP\Validation\Attribute;

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
     * @param Attribute $attribute
     *
     * @return void
     */
    public function setAttribute(Attribute $attribute);

    /**
     * @return Attribute
     */
    public function getAttribute() : Attribute;

    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getData() : array;

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($value) : bool;
}
