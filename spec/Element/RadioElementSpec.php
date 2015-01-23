<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface as Node;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\RadioElement */
class RadioElementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\RadioElement');
        $this->shouldImplement('DeForm\Element\GroupInterface');
    }

    function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_return_name_element()
    {
        $this->getName()->shouldReturn('foo');
    }

    function it_return_elements_of_group()
    {
        $this->getElements()->shouldBeArray();
    }

    function it_append_valid_element_to_group(Node $el1)
    {
        $el1->getElementType()->willReturn('input_radio');
        $el1->getAttribute('name')->willReturn('foo')->shouldBeCalled();

        $this->addElement($el1)->shouldHaveType('DeForm\Element\RadioElement');
    }

    function it_throw_exception_through_add_invalid_elements_to_group(Node $el1, Node $el2)
    {
        $el1->getElementType()->willReturn('input_text');

        $el2->getElementType()->willReturn('input_radio');
        $el2->getAttribute('name')->willReturn('bar')->shouldBeCalled();

        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el1]);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }

    function it_return_group_value_for_not_selected_elements(Node $el1, Node $el2, Node $el3)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);

        $this->getValue()->shouldReturn(null);
    }

    function it_return_group_value_for_selected_element(Node $el1, Node $el2, Node $el3, Node $el4)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');
        $this->prepare_node_element($el4, 'fourth', true);

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);
        $this->addElement($el4);

        $this->getValue()->shouldReturn('fourth');
    }

    function it_should_set_checked_attribute_based_on_element_value(Node $el1, Node $el2, Node $el3, Node $el4, Node $el5)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');
        $this->prepare_node_element($el4, 'fourth');
        $this->prepare_node_element($el5, 'fifth', true);

        $el5->removeAttribute('checked')->shouldBeCalled();
        $el4->setAttribute('checked', 'checked')->shouldBeCalled();

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);
        $this->addElement($el4);
        $this->addElement($el5);

        $this->setValue('fourth')->shouldHaveType('DeForm\Element\RadioElement');
    }

    protected function prepare_node_element(Node $item, $value, $isChecked = false)
    {
        $item->getAttribute('name')->willReturn('foo')->shouldBeCalled();
        $item->getAttribute('value')->willReturn($value);
        $item->hasAttribute('checked')->willReturn($isChecked);
        $item->getElementType()->willReturn('input_radio')->shouldBeCalled();
    }

}
