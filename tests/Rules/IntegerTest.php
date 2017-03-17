<?php

namespace Rules;

use SGP\Validation\Rules\Integer;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Validation\Rules\Integer
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Integer();
    }

    /**
     * @test
     *
     * @covers Integer::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('int', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers Integer::passes()
     */
    public function shouldCheckIfInputIsNumeric()
    {
        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertTrue($this->rule->passes(0));
        $this->assertTrue($this->rule->passes('0'));
        $this->assertTrue($this->rule->passes(-42));
        $this->assertTrue($this->rule->passes('-42'));
        $this->assertTrue($this->rule->passes(+42));
        $this->assertTrue($this->rule->passes('+42'));
        $this->assertTrue($this->rule->passes(0x1A));

        $this->assertFalse($this->rule->passes(true));
        $this->assertFalse($this->rule->passes(false));

        $this->assertFalse($this->rule->passes('042'));
        $this->assertFalse($this->rule->passes('0042'));
        $this->assertFalse($this->rule->passes('1e10'));
        $this->assertFalse($this->rule->passes(10.12));
        $this->assertFalse($this->rule->passes('10.12'));
        $this->assertFalse($this->rule->passes(null));
        $this->assertFalse($this->rule->passes(''));
        $this->assertFalse($this->rule->passes('string'));
        $this->assertFalse($this->rule->passes('0x1A'));
        $this->assertFalse($this->rule->passes(array('foo', 'bar')));
    }
}
