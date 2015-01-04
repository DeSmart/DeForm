<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;
use DeForm\Request\RequestInterface;
use DeForm\Node\NodeInterface;
use DeForm\Element\ElementInterface;
use DeForm\DeForm;

class DeFormSpec extends ObjectBehavior
{
    function let(NodeInterface $formNode, RequestInterface $request)
    {
        $formNode->getAttribute('name')->willReturn('foo');

        $this->beConstructedWith($formNode, $request);
    }

    function it_should_check_if_the_form_was_submitted(RequestInterface $request)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('foo');

        $this->isSubmitted()->shouldReturn(true);
    }

    function it_should_check_if_the_form_was_not_submitted(RequestInterface $request)
    {
        $request->get(DeForm::DEFORM_ID)->willReturn('bar');

        $this->isSubmitted()->shouldReturn(false);
    }

    function it_should_throw_exception_while_setting_same_element_twice(ElementInterface $element)
    {
        $element->getName()->willReturn('foo');

        $this->addElement($element);

        $this->shouldThrow('\LogicException')->during('addElement', array($element));
    }

    function it_should_throw_exception_while_getting_nonexisting_element()
    {
        $this->shouldThrow('\LogicException')->during('getElement', array('bar'));
    }

    function it_should_set_element_values_with_values_from_request(
        RequestInterface $request,
        ElementInterface $el1,
        ElementInterface $el2,
        ElementInterface $el3,
        ElementInterface $el4,
        ElementInterface $el5
    )
    {
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('foo');
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

    function it_should_return_element_values_excluding_deform_id(RequestInterface $request, ElementInterface $el1, ElementInterface $el2, ElementInterface $el3, ElementInterface $el4) {
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
        $el4->getValue()->willThrow('\DeForm\Element\Exceptions\ElementHasNoValueException');

        $this->addElement($el1);
        $this->addElement($el2);
        $this->addElement($el3);
        $this->addElement($el4);

        $this->getData()->shouldReturn(array(
            'field_1' => 'new_value',
            'field_2' => 'field_2_value',
        ));
    }

}
