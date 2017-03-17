<?php

use SGP\Validation\Attribute;
use SGP\Validation\Contracts\Rule;
use SGP\Validation\Rules\Max;
use SGP\Validation\Rules\Min;
use SGP\Validation\Rules\Required;

class AttributeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * Mock few rules before each test.
     */
    protected function setUp()
    {
        $minRule = $this->getMockBuilder(Min::class)
            ->setMethods(['getSlug'])
            ->getMock();

        $minRule->expects($this->once())
            ->method('getSlug')
            ->with()
            ->willReturn('min');

        $maxRule = $this->getMockBuilder(Max::class)
            ->setMethods(['getSlug'])
            ->getMock();

        $maxRule->expects($this->once())
            ->method('getSlug')
            ->with()
            ->willReturn('max');

        $requiredRule = $this->getMockBuilder(Required::class)
            ->setMethods(['getSlug'])
            ->getMock();

        $requiredRule->expects($this->once())
            ->method('getSlug')
            ->with()
            ->willReturn('required');

        $this->rules = [$minRule, $maxRule, $requiredRule];
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::getRule()
     */
    public function shouldRegisterRules()
    {
        $attributeName = 'username';
        $required = false;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertTrue(is_array($attribute->getRules()));
        $this->assertSame(3, count($attribute->getRules()));

        array_map(function ($rule) {
            $this->assertInstanceOf(Rule::class, $rule);
        }, $attribute->getRules());
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::isRequired()
     */
    public function attributeValidationShouldBeOptional()
    {
        $attributeName = 'username';
        $required = false;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertFalse($attribute->isRequired());
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::isRequired()
     */
    public function attributeValidationShouldBeRequired()
    {
        $attributeName = 'username';
        $required = true;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertTrue($attribute->isRequired());
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::getRule()
     */
    public function shouldReturnRuleIfRegistered()
    {
        $attributeName = 'username';
        $required = true;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertNotNull($attribute->getRule('min'));
        $this->assertNotNull($attribute->getRule('max'));
        $this->assertNotNull($attribute->getRule('required'));

        $this->assertNull($attribute->getRule('non-existent'));
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::hasRule()
     */
    public function shouldDetermineIfRuleExists()
    {
        $attributeName = 'username';
        $required = true;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertTrue($attribute->hasRule('min'));
        $this->assertTrue($attribute->hasRule('max'));
        $this->assertTrue($attribute->hasRule('required'));

        $this->assertFalse($attribute->hasRule('non-existent'));
    }

    /**
     * @test
     *
     * @covers Attribute
     * @covers Attribute::addRule()
     * @covers Attribute::getKey()
     */
    public function shouldReturnAttributeName()
    {
        $attributeName = 'username';
        $required = true;

        $attribute = new Attribute($attributeName, $this->rules, $required);

        $this->assertSame($attributeName, $attribute->getKey());
    }
}
