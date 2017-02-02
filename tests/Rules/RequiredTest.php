<?php

namespace Rules;

use Validation\Rules\Required;

class RequiredTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Required
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Required();
    }

    /**
     * @test
     *
     * @covers Required::passes()
     */
    public function shouldValidateNumericValues()
    {
        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertTrue($this->rule->passes('0'));
        $this->assertTrue($this->rule->passes(0));
        $this->assertTrue($this->rule->passes(-1));
    }

    /**
     * @test
     *
     * @covers Required::passes()
     */
    public function shouldValidateStrings()
    {
        $this->assertTrue($this->rule->passes('string'));
        $this->assertTrue($this->rule->passes(' string '));

        $this->assertFalse($this->rule->passes(''));
        $this->assertFalse($this->rule->passes('            '));
    }

    /**
     * @test
     *
     * @covers Required::passes()
     */
    public function shouldValidateArray()
    {
        $this->assertTrue($this->rule->passes([1]));
        $this->assertTrue($this->rule->passes([null]));
        $this->assertTrue($this->rule->passes([null, null]));
        $this->assertTrue($this->rule->passes(['string']));
        $this->assertTrue($this->rule->passes([
            'key' => 'value'
        ]));

        $this->assertFalse($this->rule->passes([]));
    }

    /**
     * @test
     *
     * @covers Required::passes()
     */
    public function shouldValidateNull()
    {
        $this->assertFalse($this->rule->passes(null));

        $this->assertTrue($this->rule->passes('null'));
        $this->assertTrue($this->rule->passes(0));
    }
}
