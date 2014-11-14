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
        
        $this->addElement($element);
        
        $this->shouldThrow('\LogicException')->during('addElement', array($element));
    }
    
    function it_should_throw_exception_while_getting_nonexisting_element()
    {
        $this->shouldThrow('\LogicException')->during('getElement', array('bar'));
    }
    
    function it_should_set_element_values_with_values_from_request() {
        $requestData = array(
            'field_1' => 'bar',
            'field_2' => 42,
        );
        
        for ($i = 0; $i < 4; $i++) {
            $fieldName = 'field_'.$i;
            
            $element = $this->getProphet()->prophesize('\DeForm\Element\ElementInterface');
            $element->getName()->willReturn($fieldName);
            
            if (true === isset($requestData[$fieldName])) {
                $element->getValue()->willReturn($requestData[$fieldName]);
            }
            else {
                $element->getValue()->willReturn($fieldName);
            }
            
            $this->addElement($element);
            
            if (true === isset($requestData[$fieldName])) {
                $this->getElement($fieldName)->getValue()->shouldReturn($requestData[$fieldName]);
            }
            else {
                $this->getElement($fieldName)->getValue()->shouldReturn($fieldName);
            }
        }
    }

}
