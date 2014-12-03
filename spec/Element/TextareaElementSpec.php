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

    function it_return_element_value(TextareaValueInterface $textValue)
    {
        $textValue->getValue()->shouldBeCalled()->willReturn('abc');
        $this->getValue()->shouldReturn('abc');
    }

    function it_should_set_element_value(TextareaValueInterface $textValue)
    {
        $textValue->setValue('foo')->shouldBeCalled();
        $this->setValue('foo');
    }

    function it_is_readonly_element_by_disabled_attribute(NodeInterface $node)
    {
        $node->hasAttribute('readonly')->willReturn(false);
        $node->hasAttribute('disabled')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_is_readonly_element_by_readonly_attribute(NodeInterface $node)
    {
        $node->hasAttribute('disabled')->willReturn(false);
        $node->hasAttribute('readonly')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_return_name_element(NodeInterface $node)
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

    function it_is_return_valid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(false);
        $this->shouldBeValid();
    }

    function it_is_return_not_valid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(true);
        $this->shouldNotBeValid();
    }
}
