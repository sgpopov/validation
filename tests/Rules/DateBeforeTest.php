<?php

namespace Rules;

use Validation\Rules\DateBefore;

class DateBeforeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateBefore
     */
    protected $rule;

    protected function setUp()
    {
        $this->rule = new DateBefore();
    }

    /**
     * @test
     *
     * @covers DateBefore::getSlug()
     */
    public function shouldReturnCorrectSlug()
    {
        $this->assertSame('date_before', $this->rule->getSlug());
    }

    /**
     * @test
     *
     * @covers DateBefore::passes()
     */
    public function shouldRaiseExceptionForMissingParam()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Validation rule date_before requires at least 1 parameters.'
        );

        $this->rule->setParams([]);

        $this->assertTrue($this->rule->passes('some date'));
    }

    /**
     * @test
     *
     * @covers DateBefore::passes()
     */
    public function shouldRaisExceptionForInvalidAttributeDate()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Attribute value must be a valid date.'
        );

        $this->rule->setParams(['2010-10-10']);

        $this->assertTrue($this->rule->passes('some date'));
    }

    /**
     * @test
     *
     * @covers DateBefore::passes()
     */
    public function shouldRaisExceptionForInvalidParamDate()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            'Supplied date \'some date\' is invalid.'
        );

        $this->rule->setParams(['some date']);

        $this->assertTrue($this->rule->passes('2010-10-10'));
    }

    /**
     * @test
     *
     * @covers DateBefore::getMessage()
     */
    public function shouldReturnCorrectMessage()
    {
        $this->rule->setParams(['2010-10-10']);

        $this->assertSame(
            'The :attribute date must be before 2010-10-10.',
            $this->rule->getMessage()
        );
    }

    /**
     * @test
     *
     * @covers DateBefore::passes()
     */
    public function shouldCompareTwoDates()
    {
        $falsyTests = [
            '2010-10-10' => '2010-10-11',
            '2010-10-10 00:00:00' => '2010-10-10',
            '10 July 2017' => '20 July 2017',
            '10 Feb 2017' => '10 Feb 2017 00:00:01',
            '2017/02/10' => '2017/02/21',
            '02.10.2017' => '27.10.2017',
            '2.10.2017' => '22.10.2017',
            '2.8.2017' => '13.8.2017',
            '2.8.98' => '13.8.98',
            'Feb 2017' => 'Mar 2017',
            'Feb 2017' => '2017-03-01',
            'Feb 2017 10:10:10' => '2 Feb 2017',
            '2017/02/10 11:23:33' => '2017/02/10 11:23:34'
        ];

        foreach ($falsyTests as $dateAfter => $input) {
            $this->rule->setParams((array) $dateAfter);
            $this->assertFalse($this->rule->passes($input));
        }

        $truthyTests = [
            '2010-10-10' => '2010-10-09',
            '2010-10-10 00:00:00' => '2010-10-09',
            '11 July 2017' => '10 July 2017 23:59:59',
            '2017/02/10' => '2017-02-09 23:59:59',
            '2 Jan 2017' => 'Jan 2017'
        ];

        foreach ($truthyTests as $dateAfter => $input) {
            $this->rule->setParams((array) $dateAfter);
            $this->assertTrue($this->rule->passes($input));
        }
    }
}
