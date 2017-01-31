<?php

namespace Rules;

use svil4ok\Validation\Rules\Min;

class MinTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Min
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Min();
    }

    /**
     * @test
     *
     * @covers Min::passes()
     */
    public function shouldValidateNumericValues()
    {
        $this->rule->setParams([10]);

        $this->assertTrue($this->rule->passes(10));
        $this->assertFalse($this->rule->passes('10'));
        $this->assertTrue($this->rule->passes(11));
        $this->assertTrue($this->rule->passes(201));

        $this->rule->setParams([19.99]);

        $this->assertFalse($this->rule->passes(10));
        $this->assertFalse($this->rule->passes('10'));
        $this->assertTrue($this->rule->passes(20));
        $this->assertFalse($this->rule->passes(19.991));
    }

    /**
     * @test
     *
     * @covers Min::passes()
     */
    public function shouldValidateStringsLength()
    {
        $this->rule->setParams([40]);

        $this->assertFalse($this->rule->passes('this string contains more than 40 chars'));
        $this->assertTrue($this->rule->passes('but this string contains more than 40 chars'));

        $this->rule->setParams([50]);

        $this->assertTrue($this->rule->passes('this string is exactly 50 chars so it should be OK'));
    }

    /**
     * @test
     *
     * @covers Min::passes()
     */
    public function shouldValidateArrayElementsNumber()
    {
        $this->rule->setParams([5]);

        $this->assertFalse($this->rule->passes([
            'element 1',
            'element 2',
            'element 3',
            'element 4'
        ]));

        $this->assertTrue($this->rule->passes([
            'element 1',
            'element 2',
            'element 3',
            'element 4',
            'element 5'
        ]));

        $this->assertFalse($this->rule->passes([
            'element 1' => [
                'sub elements does not count, should they?',
            ],
            'element 2',
            'element 3',
            'element 4'
        ]));

        $this->assertTrue($this->rule->passes([
            'key 1' => 'this is OK',
            'key 2' => 'this is OK',
            'key 3' => 'this is OK',
            'key 4' => 'this is OK',
            'key 5' => 'this is OK',
            'key 6' => 'this is OK'
        ]));

        $this->assertFalse($this->rule->passes((object) [
            'error' => 'Objects are not Validatable.'
        ]));
    }
}
