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
        $this->shouldHaveType('DeForm\Element\RadioGroupElement');
        $this->shouldImplement('DeForm\Element\GroupInterface');
    }

    function it_should_return_name_of_group_elements(RadioEl $el1)
    {
        $this->prepare_node_element($el1, 'first');
        $this->addElement($el1);

        $this->getName()->shouldReturn('foo');
    }

    function it_throws_exception_when_get_name_group_and_group_has_not_elements()
    {
        $this->shouldThrow('\LogicException')->during('getName');
    }

    function it_should_return_elements_of_group()
    {
        $this->getElements()->shouldBeArray();
    }

    function it_should_append_valid_element_to_group(RadioEl $el)
    {
        $el->getName()->willReturn('foo');

        $this->countElements()->shouldReturn(0);
        $this->addElement($el)->shouldHaveType('DeForm\Element\RadioGroupElement');
        $this->countElements()->shouldReturn(1);
    }

    function it_throws_exception_when_adding_non_radio_element(TextElement $el)
    {
        $this->countElements()->shouldReturn(0);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el]);
    }

    function it_throws_exception_when_adding_radio_element_with_different_name(RadioEl $el1, RadioEl $el2)
    {
        $el1->getName()->willReturn('foo');
        $el2->getName()->willReturn('bar')->shouldBeCalled();

        $this->countElements()->shouldReturn(0);
        $this->addElement($el1);
        $this->countElements()->shouldReturn(1);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }

    function it_should_return_value_of_group_with_not_selected_elements(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'third');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->getValue()->shouldReturn(null);
    }

    function it_should_return_value_of_group_with_selected_element(RadioEl $el1, RadioEl $el2, RadioEl $el3, RadioEl $el4)
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

    function it_should_set_checked_attribute_when_method_set_value_is_calling_with_argument_of_type_string(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');
        $this->prepare_node_element($el3, 'three', true);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->setValue('second')->shouldHaveType('DeForm\Element\RadioGroupElement');
    }

    function it_should_set_checked_attribute_when_method_set_value_is_calling_with_argument_of_type_integer(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, '1');
        $this->prepare_node_element($el2, '2');
        $this->prepare_node_element($el3, '3', true);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->setValue(2)->shouldHaveType('DeForm\Element\RadioGroupElement');
    }

    function it_should_set_checked_attribute_when_method_set_value_is_calling_with_argument_of_type_float(RadioEl $el1, RadioEl $el2, RadioEl $el3)
    {
        $this->prepare_node_element($el1, '0.1');
        $this->prepare_node_element($el2, '0.2');
        $this->prepare_node_element($el3, '0.3', true);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->setValue(.2)->shouldHaveType('DeForm\Element\RadioGroupElement');
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

    function it_should_be_readonly_group(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isReadonly()->willReturn(false)->shouldBeCalled();
        $el2->isReadonly()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeReadonly();
    }

    function it_should_not_be_readonly_group(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isReadonly()->willReturn(false)->shouldBeCalled();
        $el2->isReadonly()->willReturn(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldNotBeReadonly();
    }

    function it_should_be_valid_group_elements(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeValid();
    }

    function it_should_be_invalid_group_elements(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldNotBeValid();
    }

    function it_should_set_each_element_of_group_as_invalid(RadioEl $el1, RadioEl $el2, RadioEl $el3)
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

    function it_should_set_each_element_of_group_as_valid(RadioEl $el1, RadioEl $el2, RadioEl $el3)
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

    function it_should_get_a_single_element_from_group_by_value(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two', true);

        $this->addElement($el1)
            ->addElement($el2);

        $this->getElement('one')->shouldBe($el1);
        $this->getElement('two')->shouldBe($el2);
        $this->getElement('three')->shouldBe(null);
    }

    function it_should_return_number_of_elements_in_group(RadioEl $el1, RadioEl $el2)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');

        $this->countElements()->shouldReturn(0);

        $this->addElement($el1)
            ->addElement($el2);

        $this->countElements()->shouldReturn(2);
    }

    protected function prepare_node_element(RadioEl $item, $value, $isChecked = false)
    {
        $item->getName()->willReturn('foo')->shouldBeCalled();
        $item->getValue()->willReturn($value);
        $item->isChecked()->willReturn($isChecked);
    }

}