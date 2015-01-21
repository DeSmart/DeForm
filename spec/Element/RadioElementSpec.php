<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface;
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

    function it_append_valid_element_to_group(NodeInterface $el1)
    {
        $el1->getElementType()->willReturn('input_radio');
        $el1->getAttribute('name')->willReturn('foo')->shouldBeCalled();

        $this->addElement($el1)->shouldHaveType('DeForm\Element\RadioElement');
    }

    function it_throw_exception_through_add_invalid_elements_to_group(NodeInterface $el1, NodeInterface $el2)
    {
        $el1->getElementType()->willReturn('input_text');

        $el2->getElementType()->willReturn('input_radio');
        $el2->getAttribute('name')->willReturn('bar')->shouldBeCalled();

        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el1]);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }

    function it_return_group_value_for_not_selected_elements(NodeInterface $el1, NodeInterface $el2, NodeInterface $el3)
    {
        $this->setup_helper_elements($el1, $el2, $el3);
        $this->getValue()->shouldReturn(null);
    }

    function it_return_group_value_for_selected_element(
        NodeInterface $el1,
        NodeInterface $el2,
        NodeInterface $el3,
        NodeInterface $el4)
    {
        $this->setup_helper_elements($el1, $el2, $el3);

        $el4->getAttribute('name')->willReturn('foo')->shouldBeCalled();
        $el4->getAttribute('value')->willReturn('fourth');
        $el4->getElementType()->willReturn('input_radio');
        $el4->hasAttribute('checked')->willReturn(true);

        $this->addElement($el4);
        $this->getValue()->shouldReturn('fourth');
    }

    function it_should_set_checked_attribute_based_on_element_value(
        NodeInterface $el1,
        NodeInterface $el2,
        NodeInterface $el3,
        NodeInterface $el4,
        NodeInterface $el5)
    {
        $this->setup_helper_elements($el1, $el2, $el3);

        $el4->hasAttribute('checked')->willReturn(false);
        $el4->getAttribute('name')->willReturn('foo')->shouldBeCalled();
        $el4->getAttribute('value')->willReturn('fourth');
        $el4->getElementType()->willReturn('input_radio');
        $el4->setAttribute('checked', 'checked')->shouldBeCalled();

        $el5->hasAttribute('checked')->willReturn(true);
        $el5->getAttribute('name')->willReturn('foo')->shouldBeCalled();
        $el5->getAttribute('value')->willReturn('fifth');
        $el5->getElementType()->willReturn('input_radio');
        $el5->removeAttribute('checked')->shouldBeCalled();

        $this->addElement($el4);
        $this->addElement($el5);

        $this->setValue('fourth')->shouldHaveType('DeForm\Element\RadioElement');
    }

    protected function setup_helper_elements(NodeInterface $el1, NodeInterface $el2, NodeInterface $el3)
    {
        $el1->getAttribute('value')->willReturn('first');
        $el2->getAttribute('value')->willReturn('second');
        $el3->getAttribute('value')->willReturn('third');

        foreach (func_get_args() as $item) {
            $item->hasAttribute('checked')->willReturn(false);
            $item->getAttribute('name')->willReturn('foo');
            $item->getElementType()->willReturn('input_radio')->shouldBeCalled();

            $this->addElement($item);
        }
    }

}
