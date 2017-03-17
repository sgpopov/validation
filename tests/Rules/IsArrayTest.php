<?php

namespace Rules;

use SGP\Validation\Rules\IsArray;

class IsArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IsArray
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new IsArray();
    }

    /**
     * @test
     *
     * @covers IsArray::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('array', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers IsArray::passes()
     */
    public function shouldCheckIfInputIsNumeric()
    {
        $this->assertTrue($this->rule->passes([]));
        $this->assertTrue($this->rule->passes([
            'foo' => 'bar'
        ]));
        $this->assertTrue($this->rule->passes([
            'foo' => [
                'bar' => 'baz'
            ]
        ]));

        $this->assertFalse($this->rule->passes(null));
        $this->assertFalse($this->rule->passes('string'));
        $this->assertFalse($this->rule->passes(new \stdClass));
    }
}
