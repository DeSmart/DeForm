<?php

namespace spec\DeForm\Element;

use \DeForm\Element\RadioElement as RadioEl;
use DeForm\Element\TextElement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\RadioGroupElement */
class RadioGroupElementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\GroupElementRadio');
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

    function it_append_valid_element_to_group(RadioEl $el1)
    {
        $el1->getName()->willReturn('foo')->shouldBeCalled();
        $this->addElement($el1)->shouldHaveType('DeForm\Element\GroupElementRadio');
    }

    function it_throw_exception_through_add_invalid_elements_to_group(TextElement $el1, RadioEl $el2)
    {
        $el2->getName()->willReturn('bar')->shouldBeCalled();

        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el1]);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }

    function it_return_group_value_for_not_selected_elements(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->getValue()->shouldReturn(null);
    }

    function it_return_group_value_for_selected_element(RadioEl $el1, RadioEl $el2, RadioEl $el3, RadioEl $el4)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');
        $this->prepare_node_element($el4, 'fourth', true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4);

        $this->getValue()->shouldReturn('fourth');
    }

    function it_should_set_checked_attribute_based_on_element_value(RadioEl $el1, RadioEl $el2, RadioEl $el3, RadioEl $el4, RadioEl $el5)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');
        $this->prepare_node_element($el4, 'fourth');
        $this->prepare_node_element($el5, 'fifth', true);

        $el5->setUnchecked()->shouldBeCalled();
        $el4->setChecked()->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4)
            ->addElement($el5);

        $this->setValue('fourth')->shouldHaveType('DeForm\Element\GroupElementRadio');
    }

    function it_is_readonly_through_disabled_attribute(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isReadonly()->willReturn(false)->shouldBeCalled();
        $el2->isReadonly()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeReadonly();
    }

    function it_is_valid_group_of_elements(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeValid();
    }

    function it_is_invalid_group_of_elements(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldNotBeValid();
    }

    function it_should_set_every_element_on_invalid(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $message = 'Invalid element.';

        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');
        $this->prepare_node_element($el3, 'three');

        foreach (func_get_args() as $el) {
            $el->setInvalid($message)->shouldBeCalled();
        }

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->setInvalid($message);
    }

    function it_should_set_every_element_on_valid(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');
        $this->prepare_node_element($el3, 'three');

        foreach (func_get_args() as $el) {
            $el->setValid()->shouldBeCalled();
        }

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->setValid();
    }

    function it_should_a_single_element_from_group(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two', true);

        $this->addElement($el1)
            ->addElement($el2);

        $first_el = $this->getElement('one');
        $first_el->shouldImplement('DeForm\Element\ElementInterface');
        $first_el->shouldImplement('DeForm\Element\CheckedElementInterface');
        $first_el->isChecked()->shouldReturn(false);
        $first_el->getValue()->shouldReturn('one');

        $second_el = $this->getElement('two');
        $second_el->shouldImplement('DeForm\Element\ElementInterface');
        $second_el->shouldImplement('DeForm\Element\CheckedElementInterface');
        $second_el->isChecked()->shouldReturn(true);
        $second_el->getValue()->shouldReturn('two');

        $this->shouldThrow('\InvalidArgumentException')->during('getElement', ['three']);
    }

    protected function prepare_node_element(RadioEl $item, $value, $isChecked = false)
    {
        $item->getName()->willReturn('foo')->shouldBeCalled();
        $item->getValue()->willReturn($value);
        $item->isChecked()->willReturn($isChecked);
    }

}