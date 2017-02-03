<?php

namespace Rules;

use Validation\Rules\AlphaNum;

class AlphaNumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlphaNum
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new AlphaNum();
    }

    /**
     * @test
     *
     * @covers AlphaNum::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('alpha_num', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers AlphaNum::passes()
     */
    public function shouldCheckIfInputIsNumeric()
    {
        $this->assertTrue($this->rule->passes('string'));
        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertTrue($this->rule->passes(0));
        $this->assertTrue($this->rule->passes('0'));
        $this->assertTrue($this->rule->passes(-42));
        $this->assertTrue($this->rule->passes('-42'));
        $this->assertTrue($this->rule->passes(+42));
        $this->assertFalse($this->rule->passes('+42'));
        $this->assertTrue($this->rule->passes(0x1A));
        $this->assertTrue($this->rule->passes('042'));
        $this->assertTrue($this->rule->passes('0042'));
        $this->assertTrue($this->rule->passes('1e10'));
        $this->assertTrue($this->rule->passes('0x1A'));
        $this->assertTrue($this->rule->passes('042'));
        $this->assertTrue($this->rule->passes('0042'));
        $this->assertTrue($this->rule->passes('1e10'));
        $this->assertTrue($this->rule->passes('0x1A'));

        $this->assertFalse($this->rule->passes(' string'));
        $this->assertFalse($this->rule->passes('string '));
        $this->assertFalse($this->rule->passes(' string '));
        $this->assertFalse($this->rule->passes(true));
        $this->assertFalse($this->rule->passes(false));
        $this->assertFalse($this->rule->passes(10.12));
        $this->assertFalse($this->rule->passes('10.12'));
        $this->assertFalse($this->rule->passes(null));
        $this->assertFalse($this->rule->passes(''));
        $this->assertFalse($this->rule->passes(array('foo', 'bar')));
    }
}
