<?php

namespace Rules;

use SGP\Validation\Rules\Equals;

class EqualsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Equals
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Equals;
    }

    /**
     * @test
     *
     * @covers Equals::passes()
     */
    public function shouldRaiseExceptionForMissingParams()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Validation rule equals requires at least 1 parameters.'
        );

        $this->rule->setParams([]);

        $this->assertTrue($this->rule->passes(10));
    }

    /**
     * @test
     *
     * @covers Equals::getMessage()
     */
    public function shouldReturnFormattedMessage()
    {
        $this->rule->setData([]);
        $this->rule->setParams(['field1']);

        $this->assertSame(
            $this->rule->getMessage(),
            'The :attribute must be equal to :value.'
        );
    }

    /**
     * @test
     *
     * @covers Equals::passes()
     */
    public function shouldValidateInput()
    {
        $this->rule->setParams(['foo']);

        $this->assertTrue($this->rule->passes('foo'));
        $this->assertFalse($this->rule->passes('wrong-value'));

        $this->rule->setParams([[
            'key' => 'value'
        ]]);
        $this->assertTrue($this->rule->passes([
            'key' => 'value'
        ]));
        $this->assertFalse($this->rule->passes('wrong-value'));
    }
}
