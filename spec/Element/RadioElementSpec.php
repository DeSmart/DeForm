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

    function let(NodeInterface $el1, NodeInterface $el2, NodeInterface $el3)
    {
        $this->beConstructedWith('foo');

        $el1->getAttribute('value')->willReturn('first');
        $el2->getAttribute('value')->willReturn('second');
        $el3->getAttribute('value')->willReturn('third');

        foreach (func_get_args() as $element) {
            $element->getAttribute('name')->willReturn('foo');
            $element->getElementType()->willReturn('input_radio');

            $this->addElement($element);
        }
    }

    function it_return_name_element()
    {
        $this->getName()->shouldReturn('foo');
    }

    function it_append_valid_element_to_group(NodeInterface $el1)
    {
        $el1->getElementType()->willReturn('input_radio');
        $this->addElement($el1)->shouldHaveType('DeForm\Element\RadioElement');
    }

    function it_throw_exception_through_add_invalid_elements_to_group(NodeInterface $el1, NodeInterface $el2)
    {
        $el1->getElementType()->willReturn('input_text');
        $el2->getElementType()->willReturn('textarea');

        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el1]);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }
}
