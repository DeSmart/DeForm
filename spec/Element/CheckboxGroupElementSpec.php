<?php

namespace spec\DeForm\Element;

use DeForm\Element\CheckboxElement as CheckboxEl;
use DeForm\Element\TextElement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\CheckboxGroupElement */
class CheckboxGroupElementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\CheckboxGroupElement');
        $this->shouldImplement('DeForm\Element\GroupInterface');
    }

    function it_should_return_name_of_group_elements(CheckboxEl $el1)
    {
        $this->prepare_node_element($el1, 'first', false);
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

    function it_should_append_valid_element_to_group(CheckboxEl $el)
    {
        $el->getName()->willReturn('foo');

        $this->countElements()->shouldReturn(0);
        $this->addElement($el)->shouldHaveType('DeForm\Element\CheckboxGroupElement');
        $this->countElements()->shouldReturn(1);
    }

    function it_throws_exception_when_adding_non_checkbox_element(TextElement $el)
    {
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el]);
    }

    function it_throws_exception_when_adding_checkbox_element_with_different_name(CheckboxEl $el1, CheckboxEl $el2)
    {
        $el1->getName()->willReturn('foo');
        $el2->getName()->willReturn('bar')->shouldBeCalled();

        $this->countElements()->shouldReturn(0);
        $this->addElement($el1);
        $this->countElements()->shouldReturn(1);
        $this->shouldThrow('\InvalidArgumentException')->during('addElement', [$el2]);
    }

    function it_should_be_readonly_group(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isReadonly()->willReturn(false)->shouldBeCalled();
        $el2->isReadonly()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeReadonly();
    }

    function it_should_not_be_readonly_group(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isReadonly()->willReturn(false)->shouldBeCalled();
        $el2->isReadonly()->willReturn(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldNotBeReadonly();
    }

    function it_should_be_valid_group_elements(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(true)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldBeValid();
    }

    function it_should_be_invalid_group_elements(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two');

        $el1->isValid()->willReturn(true)->shouldBeCalled();
        $el2->isValid()->willReturn(false)->shouldBeCalled();

        $this->addElement($el1)
            ->addElement($el2);

        $this->shouldNotBeValid();
    }

    function it_should_set_each_element_of_group_as_invalid(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
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

    function it_should_set_each_element_of_group_as_valid(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
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

    function it_should_get_a_single_element_from_group_by_value(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'one');
        $this->prepare_node_element($el2, 'two', true);

        $this->addElement($el1)
            ->addElement($el2);

        $this->getElement('one')->shouldBe($el1);
        $this->getElement('two')->shouldBe($el2);
        $this->getElement('three')->shouldBe(null);
    }

    function it_should_return_number_of_elements_in_group(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'second');

        $this->countElements()->shouldReturn(0);

        $this->addElement($el1)
            ->addElement($el2);

        $this->countElements()->shouldReturn(2);
    }

    function it_should_return_array_with_values_of_checked_elements(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
    {
        $this->prepare_node_element($el1, 'first', true);
        $this->prepare_node_element($el2, 'two');
        $this->prepare_node_element($el3, 'three', true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $this->getValue()->shouldBe([
            'first',
            'three',
        ]);
    }

    function it_should_return_empty_array_when_group_have_not_checked_elements(CheckboxEl $el1, CheckboxEl $el2)
    {
        $this->prepare_node_element($el1, 'first');
        $this->prepare_node_element($el2, 'two');

        $this->addElement($el1)
            ->addElement($el2);

        $this->getValue()->shouldBe([]);
    }

    function it_should_set_value_of_group_based_on_argument_of_type_string(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
    {
        $this->prepare_node_element($el1, 'first', true);
        $this->prepare_node_element($el2, 'two');
        $this->prepare_node_element($el3, 'three', true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->setValue('two')->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_argument_of_type_integer(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
    {
        $this->prepare_node_element($el1, '1', true);
        $this->prepare_node_element($el2, '2');
        $this->prepare_node_element($el3, '3', true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->setValue(2)->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_argument_of_type_float(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3)
    {
        $this->prepare_node_element($el1, '0.1', true);
        $this->prepare_node_element($el2, '0.2');
        $this->prepare_node_element($el3, '0.3', true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();

        $this->setValue(.2)->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_array_with_string_elements(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3, CheckboxEl $el4)
    {
        $this->prepare_node_element($el1, 'one', true);
        $this->prepare_node_element($el2, 'two');
        $this->prepare_node_element($el3, 'three', true);
        $this->prepare_node_element($el4, 'four');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();
        $el4->setValue(true)->shouldBeCalled();

        $this->setValue(['two', 'four'])->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_array_with_integer_elements(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3, CheckboxEl $el4)
    {
        $this->prepare_node_element($el1, '1', true);
        $this->prepare_node_element($el2, '2');
        $this->prepare_node_element($el3, '3', true);
        $this->prepare_node_element($el4, '4');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();
        $el4->setValue(true)->shouldBeCalled();

        $this->setValue([2, 4])->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_array_with_float_elements(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3, CheckboxEl $el4)
    {
        $this->prepare_node_element($el1, '0.1', true);
        $this->prepare_node_element($el2, '0.2');
        $this->prepare_node_element($el3, '0.3', true);
        $this->prepare_node_element($el4, '0.4');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4);

        $el1->setValue(false)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(false)->shouldBeCalled();
        $el4->setValue(true)->shouldBeCalled();

        $this->setValue([0.2, 0.4])->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_set_value_of_group_based_on_array_with_mixed_elements(CheckboxEl $el1, CheckboxEl $el2, CheckboxEl $el3, CheckboxEl $el4)
    {
        $this->prepare_node_element($el1, 'one', true);
        $this->prepare_node_element($el2, '2');
        $this->prepare_node_element($el3, '0.3', true);
        $this->prepare_node_element($el4, 'four');

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->addElement($el4);

        $el1->setValue(true)->shouldBeCalled();
        $el2->setValue(true)->shouldBeCalled();
        $el3->setValue(true)->shouldBeCalled();
        $el4->setValue(false)->shouldBeCalled();

        $this->setValue(['one', 2, 0.3])->shouldHaveType('DeForm\Element\CheckboxGroupElement');
    }

    function it_should_throws_exception_when_method_set_value_is_calling_with_argument_of_type_object()
    {
        $arg = new \StdClass;
        $arg->foo = 'bar';

        $this->shouldThrow('\InvalidArgumentException')->during('setValue', [
            $arg
        ]);
    }

    protected function prepare_node_element(CheckboxEl $item, $value, $isChecked = false)
    {
        $item->getName()->willReturn('foo')->shouldBeCalled();
        $item->getValue()->willReturn($value);
        $item->isChecked()->willReturn($isChecked);
    }
}
