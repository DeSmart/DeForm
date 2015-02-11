<?php

namespace spec\DeForm\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextareaValueSpec extends ObjectBehavior
{
    function let()
    {
        $text = new \DOMText('abc');
        $this->beConstructedWith($text);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\TextareaValue');
        $this->shouldImplement('DeForm\Element\TextareaValueInterface');
    }

    function it_should_return_value_of_node()
    {
        $this->getValue()->shouldReturn('abc');
    }

    function it_should_set_return_value_on_foo()
    {
        $this->setValue('foo')->shouldHaveType('DeForm\Element\TextareaValue');
        $this->getValue()->shouldReturn('foo');
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_string()
    {
        $arg = 'abc';

        $this->setValue($arg)->shouldHaveType('DeForm\Element\TextareaValue');
        $this->getValue()->shouldReturn($arg);
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_integer()
    {
        $arg = 123;

        $this->setValue($arg)->shouldHaveType('DeForm\Element\TextareaValue');
        $this->getValue()->shouldReturn((string) $arg);
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_float()
    {
        $arg = 0.5;

        $this->setValue($arg)->shouldHaveType('DeForm\Element\TextareaValue');
        $this->getValue()->shouldReturn((string) $arg);
    }

    function it_should_throws_exception_when_method_set_value_is_calling_with_argument_of_type_array()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [
            ['some_array']
        ]);
    }

    function it_should_throws_exception_when_method_set_value_is_calling_with_argument_of_type_object()
    {
        $arg = new \StdClass;
        $arg->foo = 'bar';

        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [
            $arg
        ]);
    }

}
