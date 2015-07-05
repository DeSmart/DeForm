<?php

namespace spec\DeForm;

use DeForm\Element\GroupInterface as Group;
use DeForm\ValidationHelper;
use PhpSpec\ObjectBehavior;
use DeForm\DeForm;
use DeForm\Element\ElementInterface as Element;
use DeForm\Request\RequestInterface as Request;
use DeForm\Document\DocumentInterface as Document;
use DeForm\Node\NodeInterface as Node;

class DeFormSpec extends ObjectBehavior
{
    function let(Node $formNode, Document $document, Request $request, ValidationHelper $validationHelper)
    {
        $formNode->getAttribute('name')->willReturn('foo');

        $this->beConstructedWith($formNode, $document, $request, $validationHelper);
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

    function it_should_throw_exception_while_setting_same_element_twice(Element $element)
    {
        $element->getName()->willReturn('foo');

        $this->addElement($element);
        $this->shouldThrow('\LogicException')->during('addElement', array($element));
    }

    function it_should_throw_exception_while_getting_nonexisting_element()
    {
        $this->shouldThrow('\LogicException')->during('getElement', array('bar'));
    }

    function it_should_set_element_values_with_values_from_request(Request $request, Element $el1, Element $el2, Element $el3, Element $el4, Element $el5)
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

    function it_should_return_element_values_excluding_deform_id(Request $request, Element $el1, Element $el2, Element $el3, Element $el4)
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

    function it_is_invalid_when_is_not_submitted()
    {
        $this->shouldNotBeValid();
    }

    function it_should_set_form_as_valid(Request $request)
    {
        // Submitted form
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');

        $this->setValid();
        $this->shouldBeValid();
    }

    function it_should_set_form_as_invalid(Request $request)
    {
        // Submitted form
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');

        $this->setInvalid();
        $this->shouldNotBeValid();
    }

    function it_validates_data(Request $request, ValidationHelper $validationHelper, Element $el1)
    {
        // Submitted form
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');
        $request->get('foo')->willReturn('bar');

        $el1->isReadonly()->willReturn(true);
        $el1->getName()->willReturn('foo');
        $el1->getValue()->willReturn('bar');
        $el1->getValidationRules()->willReturn('required');

        $this->addElement($el1);

        $rules = [
            'foo' => 'required',
        ];

        $values = [
            'foo' => 'bar',
        ];

        $elements = [
            'foo' => $el1,
        ];

        $validationHelper->validate($rules, $values)->willReturn(true);
        $validationHelper->updateValidationStatus($elements)->shouldBeCalled();

        $this->shouldBeValid();
    }

    function it_fails_validate_data(Request $request, ValidationHelper $validationHelper, Element $el1)
    {
        // Submitted form
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');
        $request->get('foo')->willReturn('bar');

        $el1->isReadonly()->willReturn(true);
        $el1->getName()->willReturn('foo');
        $el1->getValue()->willReturn('bar');
        $el1->getValidationRules()->willReturn('required');

        $this->addElement($el1);

        $rules = [
            'foo' => 'required',
        ];

        $values = [
            'foo' => 'bar',
        ];

        $elements = [
            'foo' => $el1,
        ];

        $validationHelper->validate($rules, $values)->willReturn(false);
        $validationHelper->updateValidationStatus($elements)->shouldBeCalled();

        $this->shouldNotBeValid();
    }

    function it_renders_document(Document $document)
    {
        $document->toHtml()->willReturn('foo');

        $this->render()->shouldReturn('foo');
    }

    function it_should_fill_the_form(Request $request, Element $el1, Element $el2)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');
        $request->get('field_1')->willReturn('bar');
        $request->get('field_2')->willReturn(42);

        $el1->getName()->willReturn($field_1 = 'field_1');
        $el1->isReadonly()->willReturn(false);
        $el1->setValue('bar')->shouldBeCalled();

        $el2->getName()->willReturn($field_2 = 'field_2');
        $el2->isReadonly()->willReturn(false);
        $el2->setValue(42)->shouldBeCalled();

        $this->addElement($el1);
        $this->addElement($el2);

        $el1->setValue($new_value_field_1 = 'first')->shouldBeCalled();
        $el2->setValue($new_value_field_2 = 'second')->shouldBeCalled();

        $this->fill([
            $field_1 => $new_value_field_1,
            $field_2 => $new_value_field_2,
        ]);
    }
}
