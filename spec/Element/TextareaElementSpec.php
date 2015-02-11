<?php

namespace spec\DeForm\Element;

use DeForm\Element\TextareaValueInterface;
use DeForm\Node\NodeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextareaElementSpec extends ObjectBehavior
{
    function let(NodeInterface $node, TextareaValueInterface $textValue)
    {
        $this->beConstructedWith($node, $textValue);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\TextareaElement');
        $this->shouldImplement('DeForm\Element\ElementInterface');
    }

    function it_should_return_value_of_element(TextareaValueInterface $textValue)
    {
        $textValue->getValue()->shouldBeCalled()->willReturn('abc');
        $this->getValue()->shouldReturn('abc');
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_string(TextareaValueInterface $textValue)
    {
        $arg = 'abc';

        $textValue->setValue($arg)->shouldBeCalled();
        $this->setValue($arg);
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_integer(TextareaValueInterface $textValue)
    {
        $arg = 123;

        $textValue->setValue($arg)->shouldBeCalled();
        $this->setValue($arg);
    }

    function it_should_change_value_of_element_based_on_an_argument_of_type_float(TextareaValueInterface $textValue)
    {
        $arg = 0.5;

        $textValue->setValue($arg)->shouldBeCalled();
        $this->setValue($arg);
    }

    function it_should_throws_exception_when_call_method_with_argument_of_type_array()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [
            ['some_array']
        ]);
    }

    function it_should_throws_exception_when_call_method_with_argument_of_type_object()
    {
        $arg = new \StdClass;
        $arg->foo = 'bar';

        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [
            $arg
        ]);
    }

    function it_should_be_readonly_element_based_on_disabled_attribute(NodeInterface $node)
    {
        $node->hasAttribute('readonly')->willReturn(false);
        $node->hasAttribute('disabled')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_should_be_readonly_element_based_on_readonly_attribute(NodeInterface $node)
    {
        $node->hasAttribute('disabled')->willReturn(false);
        $node->hasAttribute('readonly')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_should_return_name_of_element(NodeInterface $node)
    {
        $node->getAttribute('name')->shouldBeCalled()->willReturn('foo');

        $this->getName()->shouldReturn('foo');
    }

    function it_should_set_element_as_valid(NodeInterface $node)
    {
        $node->removeAttribute('data-invalid')->shouldBeCalled();

        $this->setValid();
    }

    function it_should_set_element_as_invalid(NodeInterface $node)
    {
        $node->setAttribute('data-invalid', 'foo')->shouldBeCalled();

        $this->setInvalid('foo');
    }

    function it_should_be_valid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(false);
        $this->shouldBeValid();
    }

    function it_should_be_invalid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(true);
        $this->shouldNotBeValid();
    }
}
