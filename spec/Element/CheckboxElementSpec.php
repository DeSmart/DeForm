<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\CheckboxElement */
class CheckboxElementSpec extends ObjectBehavior
{

    function let(NodeInterface $node)
    {
        $this->beConstructedWith($node);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\CheckboxElement');
        $this->shouldImplement('DeForm\Element\ElementInterface');
    }

    function it_should_return_element_value_if_element_has_value_and_attribute_checked(NodeInterface $node)
    {
        $node->hasAttribute('value')->willReturn(true)->shouldBeCalled();
        $node->hasAttribute('checked')->willReturn(true)->shouldBeCalled();
        $node->getAttribute('value')->willReturn('bar')->shouldBeCalled();

        $this->getValue()->shouldReturn('bar');
    }

    function it_should_return_null_value_if_element_has_value_and_has_not_attribute_checked(NodeInterface $node)
    {
        $node->hasAttribute('value')->willReturn(true)->shouldBeCalled();
        $node->hasAttribute('checked')->willReturn(false)->shouldBeCalled();

        $this->getValue()->shouldReturn(null);
    }

    function it_should_return_true_value_if_element_has_not_value_and_has_attribute_checked(NodeInterface $node)
    {
        $node->hasAttribute('value')->willReturn(false)->shouldBeCalled();
        $node->hasAttribute('checked')->willReturn(true)->shouldBeCalled();

        $this->getValue()->shouldReturn(true);
    }

    function it_should_return_true_value_if_element_has_not_value_and_attribute_checked(NodeInterface $node)
    {
        $node->hasAttribute('value')->willReturn(false)->shouldBeCalled();
        $node->hasAttribute('checked')->willReturn(false)->shouldBeCalled();

        $this->getValue()->shouldReturn(false);
    }

    function it_should_mark_element_as_checked_based_on_true_argument(NodeInterface $node)
    {
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setValue(true)->shouldBe($this);
    }

    function it_should_throws_exception_when_set_value_method_is_calling_with_not_boolean_argument(NodeInterface $node)
    {
        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [1]);
    }

    function it_should_mark_element_as_unchecked_based_on_false_argument(NodeInterface $node)
    {
        $node->removeAttribute('checked')->shouldBeCalled();

        $this->setValue(false)->shouldBe($this);
    }

    function it_is_readonly_element_through_nodes_disabled_attribute(NodeInterface $node)
    {
        $node->hasAttribute('readonly')->willReturn(false);
        $node->hasAttribute('disabled')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_is_readonly_element_through_nodes_readonly_attribute(NodeInterface $node)
    {
        $node->hasAttribute('disabled')->willReturn(false);
        $node->hasAttribute('readonly')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_should_return_name_element(NodeInterface $node)
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

    function it_should_be_checked_element(NodeInterface $node)
    {
        $node->hasAttribute('checked')->willReturn(true);
        $this->shouldBeChecked();
    }

    function it_should_not_be_checked_element(NodeInterface $node)
    {
        $node->hasAttribute('checked')->willReturn(false);
        $this->shouldNotBeChecked();
    }

    function it_should_mark_as_checked_element(NodeInterface $node)
    {
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setChecked()->shouldHaveType('DeForm\Element\CheckboxElement');
    }

    function it_should_mark_as_unchecked_element(NodeInterface $node)
    {
        $node->removeAttribute('checked')->shouldBeCalled();

        $this->setUnchecked()->shouldHaveType('DeForm\Element\CheckboxElement');
    }
}
