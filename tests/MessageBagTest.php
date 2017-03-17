<?php

use SGP\Validation\MessageBag;

class MessageBagTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @covers MessageBag::add()
     */
    public function shouldAddMessage()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test');

        $exptected = [
            'foo' => ['bar', 'baz'],
            'test' => ['test']
        ];

        $this->assertSame($exptected, $messageBag->toArray());
    }

    /**
     * @test
     *
     * @covers MessageBag::add()
     */
    public function shouldCountMessages()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test');

        $exptected = 3;

        $this->assertSame($exptected, $messageBag->count());
    }

    /**
     * @test
     *
     * @covers MessageBag::has()
     */
    public function shouldDetermineIfMessagesExistForKey()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test');

        $this->assertTrue($messageBag->has());
        $this->assertTrue($messageBag->has('foo'));
        $this->assertTrue($messageBag->has(['foo']));
        $this->assertTrue($messageBag->has('test'));
        $this->assertTrue($messageBag->has(['test']));
        $this->assertTrue($messageBag->has(['foo', 'test']));
        $this->assertTrue($messageBag->has(['fake', 'fake', 'foo']));
        $this->assertFalse($messageBag->has('bar'));
        $this->assertFalse($messageBag->has(['bar']));
        $this->assertFalse($messageBag->has(['bar', 'baz']));
    }

    /**
     * @test
     *
     * @covers MessageBag::hasAny()
     */
    public function shouldCheckIfThereAreAnyMessages()
    {
        $this->assertTrue(
            (new MessageBag())
                ->add('foo', 'bar')
                ->add('foo', 'baz')
                ->add('test', 'test')
                ->hasAny()
        );

        $this->assertFalse(
            (new MessageBag())->hasAny()
        );
    }

    /**
     * @test
     *
     * @covers MessageBag::first()
     */
    public function shouldReturnFirstMessage()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test value');

        $this->assertSame('bar', $messageBag->first());
        $this->assertSame('bar', $messageBag->first('foo'));
        $this->assertSame('test value', $messageBag->first('test'));
        $this->assertNull($messageBag->first('not exists'));
    }

    /**
     * @test
     *
     * @covers MessageBag::get()
     */
    public function shouldReturnAllMessagesForKey()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test value');

        $this->assertSame(['bar', 'baz'], $messageBag->get('foo'));
        $this->assertSame(['test value'], $messageBag->get('test'));
        $this->assertSame([], $messageBag->get('not exists'));
    }

    /**
     * @test
     *
     * @covers MessageBag::all()
     */
    public function shouldReturnAllMessagesWithoutKeys()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test value');

        $expected = ['bar', 'baz', 'test value'];

        $this->assertSame($expected, $messageBag->all());
    }

    /**
     * @test
     *
     * @covers MessageBag::toArray()
     */
    public function shouldReturnAllMessagesWithKeys()
    {
        $messageBag = new MessageBag();

        $messageBag
            ->add('foo', 'bar')
            ->add('foo', 'baz')
            ->add('test', 'test value');

        $expected = [
            'foo' => ['bar', 'baz'],
            'test' => ['test value']
        ];

        $this->assertSame($expected, $messageBag->toArray());
    }
}
