<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextElementSpec extends ObjectBehavior
{
    function let(NodeInterface $node)
    {
        $this->beConstructedWith($node);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\TextElement');
        $this->shouldImplement('DeForm\Element\ElementInterface');
    }

    function it_return_element_value(NodeInterface $node)
    {
        $node->getAttribute('value')->shouldBeCalled()->willReturn('bar');

        $this->getValue()->shouldReturn('bar');
    }

    function it_should_set_element_value(NodeInterface $node)
    {
        $node->setAttribute('value', 'abc')->shouldBeCalled();

        $this->setValue('abc');
    }

    function it_is_readonly_element(NodeInterface $node)
    {
        $node->hasAttribute('readonly')->shouldBeCalled()->willReturn(false);
        $node->hasAttribute('disabled')->shouldBeCalled()->willReturn(true);

        $this->isReadonly()->shouldReturn(true);
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
