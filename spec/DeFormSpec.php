<?php

namespace spec\DeForm;

use DeForm\Element\GroupInterface as Gr;
use PhpSpec\ObjectBehavior;
use DeForm\DeForm;
use DeForm\Element\ElementInterface as El;
use DeForm\Request\RequestInterface as Request;
use DeForm\Node\NodeInterface as Node;
use DeForm\Validation\ValidatorInterface as Validator;
use DeForm\Validation\MessageBagInterface as MessageBag;

class DeFormSpec extends ObjectBehavior
{
    function let(Node $formNode, Request $request, Validator $validator)
    {
        $formNode->getAttribute('name')->willReturn('foo');

        $this->beConstructedWith($formNode, $request, $validator);
    }

    function it_should_check_if_the_form_was_submitted(Request $request)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');

        $this->isSubmitted()->shouldReturn(true);
    }

    function it_should_check_if_the_form_was_not_submitted(Request $request)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('bar');

        $this->isSubmitted()->shouldReturn(false);
    }

    function it_should_throw_exception_while_setting_same_element_twice(El $element)
    {
        $element->getName()->willReturn('foo');

        $this->addElement($element);
        $this->shouldThrow('\LogicException')->during('addElement', array($element));
    }

    function it_should_throw_exception_while_getting_nonexisting_element()
    {
        $this->shouldThrow('\LogicException')->during('getElement', array('bar'));
    }

    function it_should_set_element_values_with_values_from_request(Request $request, El $el1, El $el2, El $el3, El $el4, El $el5)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');
        $request->get('field_1')->willReturn('bar');
        $request->get('field_2')->willReturn(42);
        $request->get('field_3')->willReturn('wat');
        $request->get('field_4')->willReturn(null);
        $request->get('field_5')->willReturn('');

        $el1->getName()->willReturn('field_1');
        $el1->isReadonly()->willReturn(false);
        $el1->setValue('bar')->shouldBeCalled();

        $el2->getName()->willReturn('field_2');
        $el2->isReadonly()->willReturn(false);
        $el2->setValue(42)->shouldBeCalled();

        $el3->getName()->willReturn('field_3');
        $el3->isReadonly()->willReturn(true);

        $el4->getName()->willReturn('field_4');

        $el5->getName()->willReturn('field_5');
        $el5->isReadonly()->willReturn(false);
        $el5->setValue('')->shouldBeCalled();

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);
        $this->addElement($el4);
        $this->addElement($el5);
    }

    function it_should_return_element_values_excluding_deform_id(Request $request, El $el1, El $el2, El $el3, El $el4)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');
        $request->get('field_1')->willReturn('new_value');
        $request->get('field_2')->shouldBeCalled();
        $request->get('field_4')->shouldBeCalled();

        $el1->getName()->willReturn('field_1');
        $el1->isReadonly()->willReturn(false);
        $el1->setValue('new_value')->shouldBeCalled();
        $el1->getValue()->willReturn('new_value');

        $el2->getName()->willReturn('field_2');
        $el2->isReadonly()->willReturn(false);
        $el2->getValue()->willReturn('field_2_value');

        $el3->getName()->willReturn(DeForm::DEFORM_ID);
        $el3->isReadonly()->willReturn(true);
        $el3->getValue()->willReturn('foo_bar');

        $el4->getName()->willReturn('field_4');
        $el4->isReadonly()->willReturn(false);
        $el4->getValue()->willReturn('');

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);
        $this->addElement($el4);

        $this->getData()->shouldReturn([
            'field_1' => 'new_value',
            'field_2' => 'field_2_value',
            'field_4' => '',
        ]);
    }

    function it_should_return_null_if_the_form_was_not_validated()
    {
        $this->isValid()->shouldBe(null);
    }

    function it_should_set_form_as_valid()
    {
        $this->setValid();
        $this->shouldBeValid();
    }

    function it_should_set_form_as_invalid()
    {
        $this->setInvalid();
        $this->shouldNotBeValid();
    }

    function it_should_validate_elements_and_return_success(Validator $validator, MessageBag $messages, El $el1, El $el2, Gr $el3)
    {
        $this->prepare_element($el1, $validator, $messages, 'input', 'required', 'foo');
        $this->prepare_element($el2, $validator, $messages, 'file', 'required', 'bar');
        $this->prepare_element($el3, $validator, $messages, 'radio', 'required', 'foobar');

        $validator->getMessages()->willReturn($messages);
        $validator->validate()->willReturn(true);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->validate();

        $this->shouldBeValid();
    }

    function it_should_validate_elements_and_return_fail(Validator $validator, MessageBag $messages, El $el1, El $el2, Gr $el3)
    {
        $this->prepare_element($el1, $validator, $messages, 'input', 'required', 'foo', 'Some error #1');
        $this->prepare_element($el2, $validator, $messages, 'file', 'required', 'bar');
        $this->prepare_element($el3, $validator, $messages, 'radio', 'required', 'foobar', 'Some error #3');

        $validator->getMessages()->willReturn($messages);
        $validator->validate()->willReturn(false);

        $this->addElement($el1)
            ->addElement($el2)
            ->addElement($el3)
            ->validate();

        $this->shouldNotBeValid();
    }

    protected function prepare_element(El $element, Validator $validator, MessageBag $messages, $name, $rules, $value, $message = null)
    {
        // Mark element as valid before validation start
        $element->setValid()->shouldBeCalled();

        // Properties of element
        $element->getName()->willReturn($name);
        $element->getValidationRules()->willReturn($rules);
        $element->getValue()->willReturn($value);

        if (null !== $message) {
            $element->setInvalid($message)->shouldBeCalled();
        }

        // Properties of validator
        $validator->addValidation($name, $rules, $value)->shouldBeCalled();
        $messages->first($name)->willReturn($message);
    }

}
