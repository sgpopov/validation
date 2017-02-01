<?php

namespace Rules;

use svil4ok\Validation\Rules\Boolean;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Boolean
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Boolean();
    }
    
    /**
     * @test
     *
     * @covers Boolean::passes()
     */
    public function shouldValidateBooleanValues()
    {
        $this->assertTrue($this->rule->passes(true));
        $this->assertFalse($this->rule->passes('true'));

        $this->assertTrue($this->rule->passes(false));
        $this->assertFalse($this->rule->passes('false'));

        $this->assertTrue($this->rule->passes(1));
        $this->assertTrue($this->rule->passes('1'));

        $this->assertTrue($this->rule->passes(0));
        $this->assertTrue($this->rule->passes('0'));

        $this->assertFalse($this->rule->passes('on'));
        $this->assertFalse($this->rule->passes('off'));
        $this->assertFalse($this->rule->passes('yes'));
        $this->assertFalse($this->rule->passes('no'));
        $this->assertFalse($this->rule->passes('11'));
        $this->assertFalse($this->rule->passes(11));
        $this->assertFalse($this->rule->passes(null));
    }
}
