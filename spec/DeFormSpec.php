<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;
use DeForm\Request\RequestInterface;
use DeForm\Node\NodeInterface;
use DeForm\Element\ElementInterface;
use Prophecy\Prophet;

class DeFormSpec extends ObjectBehavior
{
    
    /**
     * @var Prophet
     */
    private $prophet;
    
    /**
     * @return Prophet
     */
    private function getProphet()
    {
        if (true === empty($this->prophet)) {
            $this->prophet = new Prophet;
        }
        
        return $this->prophet;
    }

    function let(NodeInterface $formNode, RequestInterface $request)
    {
        $formNode->getAttribute('name')->willReturn('foo');
        
        $this->beConstructedWith($formNode, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\DeForm');
    }

    function it_should_check_if_the_form_was_submitted(RequestInterface $request)
    {
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('foo');
        
        $this->isSubmitted()->shouldReturn(true);
    }

    function it_should_check_if_the_form_was_not_submitted(RequestInterface $request)
    {
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('bar');
        
        $this->isSubmitted()->shouldReturn(false);
    }
    
    function it_should_throw_exception_while_setting_same_element_twice(ElementInterface $element)
    {
        $element->getName()->willReturn('foo');
        
        $this->setElement($element);
        
        $this->shouldThrow('\LogicException')->during('setElement', array($element));
    }
    
    function it_should_throw_exception_while_getting_nonexisting_element()
    {
        $this->shouldThrow('\LogicException')->during('getElement', array('bar'));
    }
    
    function it_should_set_element_values_with_values_from_request()
    {
        $requestData = array(
            'field_1' => 'foo',
            'field_2' => 42,
        );
        
        // Stub the form elements and register them in the form instance
        foreach ($requestData as $fieldName => $value) {
            $element = $this->getProphet()->prophesize('\DeForm\Element\ElementInterface');
            
            $element->getName()->willReturn($fieldName);
            $element->setValue($value)->shouldBeCalled();
            $element->getValue()->willReturn($value);
            
            $this->setElement($element);
        }
        
        $this->setElementsValues($requestData);
        
        foreach ($requestData as $fieldName => $value) {
            $this->getElement($fieldName)->getValue()->shouldReturn($value);
        }
    }

}
