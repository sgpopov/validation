<?php

namespace Rules;

use SGP\Validation\Rules\Same;

class SameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Same
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Same;
    }

    /**
     * @test
     *
     * @covers Same::passes()
     */
    public function shouldRaiseExceptionForMissingParams()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Validation rule same requires at least 1 parameters.'
        );

        $this->rule->setParams([]);

        $this->assertTrue($this->rule->passes(10));
    }

    /**
     * @test
     *
     * @covers Same::passes()
     */
    public function shouldValidateInput()
    {
        $data = [
            'field1' => 'value1',
            'field2' => [
                'key' => 'value'
            ]
        ];

        $this->rule->setData($data);

        $this->rule->setParams(['field1']);
        $this->assertTrue($this->rule->passes('value1'));
        $this->assertFalse($this->rule->passes('wrong-value'));

        $this->rule->setParams(['field2']);
        $this->assertTrue($this->rule->passes([
            'key' => 'value'
        ]));
        $this->assertFalse($this->rule->passes('wrong-value'));

        $this->rule->setParams(['non existen key in the data']);
        $this->assertFalse($this->rule->passes('whatever'));
    }
}
