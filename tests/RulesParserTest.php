<?php

use SGP\Validation\Contracts\Rule;
use SGP\Validation\Rules\Min;
use SGP\Validation\Rules\Required;
use SGP\Validation\RulesParser;
use SGP\Validation\Validator;

class RulesParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $validator;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $minRule;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $maxRule;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $requiredRule;

    protected function setUp()
    {
        $this->validator = $this->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRuleValidator'])
            ->getMock();

        $this->minRule = $this->getMockBuilder(Min::class)
            ->disableOriginalClone()
            ->setMethods(['setParams'])
            ->getMock();

        $this->maxRule = $this->getMockBuilder(Min::class)
            ->disableOriginalClone()
            ->setMethods(['setParams'])
            ->getMock();

        $this->requiredRule = $this->getMockBuilder(Required::class)
            ->disableOriginalClone()
            ->setMethods(['setParams'])
            ->getMock();
    }

    /**
     * @test
     *
     * @covers RulesParser::resolve()
     */
    public function shouldRaiseExceptionForInvalidRule()
    {
        $exceptionThrown = false;

        $rules = 'min|max|min-max';

        $this->minRule
            ->expects($this->once())
            ->method('setParams');

        $this->maxRule
            ->expects($this->once())
            ->method('setParams');

        $this->validator
            ->expects($this->exactly(3))
            ->method('getRuleValidator')
            ->withConsecutive(['min'], ['max'], ['min-max'])
            ->willReturnOnConsecutiveCalls(
                $this->minRule,
                $this->maxRule,
                null
            );

        try {
            $parser = new RulesParser($this->validator);
            $parser->resolve($rules);
        } catch (\Exception $e) {
            $exceptionThrown = true;

            $this->assertSame(
                "Validator for 'min-max' rule is not registered!",
                $e->getMessage()
            );
        }

        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     *
     * @covers RulesParser::resolve()
     */
    public function shouldResolveAttributeRules()
    {
        $rules = 'min|max|min:10|max:10';

        $this->minRule
            ->expects($this->exactly(2))
            ->method('setParams')
            ->withConsecutive([[]], [[10]]);

        $this->maxRule
            ->expects($this->exactly(2))
            ->method('setParams')
            ->withConsecutive([[]], [[10]]);

        $this->validator
            ->expects($this->exactly(4))
            ->method('getRuleValidator')
            ->withConsecutive(
                ['min'], ['max'], ['min'], ['max']
            )
            ->willReturnOnConsecutiveCalls(
                $this->minRule,
                $this->maxRule,
                $this->minRule,
                $this->maxRule
            );

        $parser = new RulesParser($this->validator);
        $actual = $parser->resolve($rules);

        $this->assertObjectHasAttribute('resolved', $actual);
        $this->assertObjectHasAttribute('isRequired', $actual);

        $this->assertTrue(is_array($actual->resolved));
        $this->assertSame(2, count($actual->resolved));

        array_map(function ($rule) {
            $this->assertInstanceOf(Rule::class, $rule);
        }, $actual->resolved);

        $this->assertFalse($actual->isRequired);
    }

    /**
     * @test
     *
     * @covers RulesParser::parseRule()
     */
    public function shouldParseRuleParams()
    {
        $parser = new RulesParser($this->validator);

        $ruleParams = 'min';
        $expected = ['min', []];

        $this->assertSame(
            $expected,
            invokeMethod($parser, 'parseRule', [$ruleParams])
        );

        $ruleParams = 'min:10';
        $expected = ['min', ['10']];

        $this->assertSame(
            $expected,
            invokeMethod($parser, 'parseRule', [$ruleParams])
        );

        $ruleParams = 'min:10,20';
        $expected = ['min', ['10', '20']];

        $this->assertSame(
            $expected,
            invokeMethod($parser, 'parseRule', [$ruleParams])
        );
    }
}
