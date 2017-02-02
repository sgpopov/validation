<?php

namespace Rules;

use Validation\Rules\Max;

class MaxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Max
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Max();
    }

    /**
     * @test
     *
     * @covers Min::passes()
     */
    public function shouldRaiseExceptionForMissingParams()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Validation rule max requires at least 1 parameters.'
        );

        $this->rule->setParams([]);

        $this->assertTrue($this->rule->passes(10));
    }

    /**
     * @test
     *
     * @covers Max::passes()
     */
    public function shouldValidateNumericValues()
    {
        $this->rule->setParams([10]);

        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertFalse($this->rule->passes(11));
        $this->assertFalse($this->rule->passes(201));

        $this->rule->setParams([19.99]);

        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertFalse($this->rule->passes(20));
        $this->assertFalse($this->rule->passes(19.991));

        $this->rule->setParams([19.99]);

        $this->assertTrue($this->rule->passes(10));
        $this->assertTrue($this->rule->passes('10'));
        $this->assertFalse($this->rule->passes(20));
        $this->assertFalse($this->rule->passes(19.991));
    }

    /**
     * @test
     *
     * @covers Max::passes()
     */
    public function shouldValidateStringsLength()
    {
        $this->rule->setParams([40]);

        $this->assertTrue($this->rule->passes('this string contains more than 40 chars'));
        $this->assertFalse($this->rule->passes('but this string contains more than 40 chars'));

        $this->rule->setParams([50]);

        $this->assertTrue($this->rule->passes('this string is exactly 50 chars so it should be OK'));
    }

    /**
     * @test
     *
     * @covers Max::passes()
     */
    public function shouldValidateArrayElementsNumber()
    {
        $this->rule->setParams([5]);

        $this->assertTrue($this->rule->passes([
            'element 1',
            'element 2',
            'element 3',
            'element 4',
            'element 5',
        ]));

        $this->rule->setParams([5]);

        $this->assertFalse($this->rule->passes([
            'element 1',
            'element 2',
            'element 3',
            'element 4',
            'element 5',
            'element 6',
        ]));

        $this->assertTrue($this->rule->passes([
            'element 1' => [
                'sub elements does not count, should they?',
            ],
            'element 2',
            'element 3',
            'element 4',
            'element 5'
        ]));

        $this->assertFalse($this->rule->passes([
            'key 1' => 'this is OK',
            'key 2' => 'this is OK',
            'key 3' => 'this is OK',
            'key 4' => 'this is OK',
            'key 5' => 'this is OK',
            'key 6' => 'this is key-value breaks things'
        ]));

        $this->assertFalse($this->rule->passes((object) [
            'error' => 'Objects are not Validatable.'
        ]));
    }
}
