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

    function it_should_return_element_value(NodeInterface $node)
    {
        $node->getAttribute('value')->shouldBeCalled()->willReturn('bar');

        $this->getValue()->shouldReturn('bar');
    }

    function it_should_mark_as_checked_element_based_on_an_valid_argument_of_type_string(NodeInterface $node)
    {
        $arg = 'foo';

        $node->getAttribute('value')->willReturn($arg)->shouldBeCalled();
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setValue($arg);
    }

    function it_should_mark_as_checked_element_based_on_an_valid_argument_of_type_integer(NodeInterface $node)
    {
        $arg = 123;

        $node->getAttribute('value')->willReturn((string) $arg)->shouldBeCalled();
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setValue(123);
    }

    function it_should_mark_as_checked_element_based_on_an_valid_argument_of_type_float(NodeInterface $node)
    {
        $arg = .5;

        $node->getAttribute('value')->willReturn((string) $arg)->shouldBeCalled();
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setValue($arg);
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

    function it_not_should_set_as_checked_when_argument_of_set_value_method_is_not_the_same_as_element_value(NodeInterface $node)
    {
        $node->getAttribute('value')->willReturn('foo')->shouldBeCalled();
        $node->removeAttribute('checked')->shouldBeCalled();

        $this->setValue('bar');
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

    function it_should_mark_as_checked_element(NodeInterface $node) {
        $node->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->setChecked()->shouldHaveType('DeForm\Element\CheckboxElement');
    }

    function it_should_mark_as_unchecked_element(NodeInterface $node) {
        $node->removeAttribute('checked')->shouldBeCalled();

        $this->setUnchecked()->shouldHaveType('DeForm\Element\CheckboxElement');
    }
}
