<?php

namespace Rules;

use SGP\Validation\Rules\Date;

class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Date
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new Date();
    }

    /**
     * @test
     *
     * @covers Date::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('date', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers Date::passes()
     */
    public function shouldCheckIfInputIsData()
    {
        $this->assertTrue($this->rule->passes('10 Feb 2017'));
        $this->assertTrue($this->rule->passes('2017-02-10'));
        $this->assertTrue($this->rule->passes('10-02-2017'));
        $this->assertTrue($this->rule->passes('2017/02/10'));
        $this->assertTrue($this->rule->passes('02.10.2017'));
        $this->assertTrue($this->rule->passes('2.10.2017'));
        $this->assertTrue($this->rule->passes('2.8.2017'));
        $this->assertTrue($this->rule->passes('2.8.98'));
        $this->assertTrue($this->rule->passes('Feb 2017'));
        $this->assertTrue($this->rule->passes('Feb 2017 10:10:10'));
        $this->assertTrue($this->rule->passes('2017/02/10 11:23:33'));
        $this->assertTrue($this->rule->passes('2017-02-12T15:19:21+00:00'));
        $this->assertTrue($this->rule->passes('July 1, 2017'));
        $this->assertTrue($this->rule->passes('1 July 2017'));
        $this->assertTrue($this->rule->passes('Sat Mar 10 17:16:18 MST 2001'));
        $this->assertTrue($this->rule->passes('March 10, 2001, 5:16 pm'));

        $this->assertFalse($this->rule->passes('now'));
        $this->assertFalse($this->rule->passes('today'));
        $this->assertFalse($this->rule->passes(2017));
        $this->assertFalse($this->rule->passes('2017'));
        $this->assertFalse($this->rule->passes('02 10 2017'));
        $this->assertFalse($this->rule->passes('10 02 2017'));
        $this->assertFalse($this->rule->passes('Europe/Sofia'));
        $this->assertFalse($this->rule->passes('2017-02-30'));
        $this->assertFalse($this->rule->passes('00:23:11'));
        $this->assertFalse($this->rule->passes('2.8.17'));
        $this->assertFalse($this->rule->passes('02,10,2017'));
        $this->assertFalse($this->rule->passes('1 July, 2017'));
        $this->assertFalse($this->rule->passes('2017 July 1'));
        $this->assertFalse($this->rule->passes('2017 1 July'));
        $this->assertFalse($this->rule->passes('2017, 1 July'));
    }
}
