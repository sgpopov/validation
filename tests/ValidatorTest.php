<?php

use SGP\Validation\Attribute;
use SGP\Validation\MessageBag;
use SGP\Validation\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @covers Validator::hasAsterisks()
     */
    public function shouldDetermineIfAttributeRuleHasAsterisk()
    {
        $validator = $this->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $attribute = $this->getMockBuilder(Attribute::class)
            ->disableOriginalConstructor()
            ->setMethods(['getKey'])
            ->getMock();

        $attribute->expects($this->exactly(2))
            ->method('getKey')
            ->willReturnOnConsecutiveCalls('this is simple', 'users.*.email');

        $this->assertFalse(invokeMethod($validator, 'hasAsterisks', [$attribute]));
        $this->assertTrue(invokeMethod($validator, 'hasAsterisks', [$attribute]));
    }

    /**
     * @test
     *
     * @covers Validator::getLeadingKey()
     */
    public function shouldReturnLeadingKey()
    {
        $validator = $this->getMockBuilder(Validator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $attributeKey = 'foo.*.baz';
        $expected = 'foo';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);

        $attributeKey = 'foo.bar.*.baz';
        $expected = 'foo.bar';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);

        $attributeKey = 'foo.*.bar.*.baz';
        $expected = 'foo';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);

        $attributeKey = 'foo.bar.*.*.baz';
        $expected = 'foo.bar';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);

        $attributeKey = 'foo';
        $expected = 'foo';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);

        $attributeKey = 'foo.bar';
        $expected = 'foo.bar';
        $actual = invokeMethod($validator, 'getLeadingKey', [$attributeKey]);

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldValidateRule()
    {
        $input = [
            'date' => 'this should fail',
            'userId' => '',
            'brands' => [
                [
                    'id' => 10,
                    'name' => 'Zara',
                    'description' => 'Spanish clothing and accessories retaile'
                ],
                [
                    'id' => 11,
                    'name' => 'H&M',
                    'description' => 'Swedish multinational clothing-retail'
                ]
            ]
        ];

        $rules = [
            'date' => 'required|date',
            'userId' => 'required',
            'brands.*.description' => 'required|min:40'
        ];

        $messages = [
            'userId.required' => 'Missing or empty `user_id`.'
        ];

        $validator = (new Validator($input, $rules, $messages))->run();

        $this->assertTrue($validator->errors() instanceof MessageBag);

        $expected = [
            'date' => [
                'The date is not valid date format.'
            ],
            'userId' => [
                'Missing or empty `user_id`.'
            ],
            'brands.1.description' => [
                'The brands.1.description minimum is 40'
            ]
        ];

        $this->assertSame($expected, $validator->errors()->toArray());
    }
}
