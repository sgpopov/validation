<?php

namespace Rules;

use SGP\Validation\Rules\Alpha;

class AlphaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Alpha
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Alpha();
    }

    /**
     * @test
     *
     * @covers Alpha::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('alpha', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers Alpha::passes()
     */
    public function shouldCheckIfInputIsNumeric()
    {
        $this->assertTrue($this->rule->passes('string'));

        $this->assertFalse($this->rule->passes(' string'));
        $this->assertFalse($this->rule->passes('string '));
        $this->assertFalse($this->rule->passes(' string '));
        $this->assertFalse($this->rule->passes('string-'));
        $this->assertFalse($this->rule->passes('string+'));

        $this->assertFalse($this->rule->passes(true));
        $this->assertFalse($this->rule->passes(false));
        $this->assertFalse($this->rule->passes(10));
        $this->assertFalse($this->rule->passes('10'));
        $this->assertFalse($this->rule->passes(0));
        $this->assertFalse($this->rule->passes('0'));
        $this->assertFalse($this->rule->passes(-42));
        $this->assertFalse($this->rule->passes('-42'));
        $this->assertFalse($this->rule->passes(+42));
        $this->assertFalse($this->rule->passes('+42'));
        $this->assertFalse($this->rule->passes(0x1A));
        $this->assertFalse($this->rule->passes('042'));
        $this->assertFalse($this->rule->passes('0042'));
        $this->assertFalse($this->rule->passes('1e10'));
        $this->assertFalse($this->rule->passes('0x1A'));
        $this->assertFalse($this->rule->passes(10.12));
        $this->assertFalse($this->rule->passes('10.12'));
        $this->assertFalse($this->rule->passes(null));
        $this->assertFalse($this->rule->passes(''));
        $this->assertFalse($this->rule->passes(array('foo', 'bar')));
    }
}
