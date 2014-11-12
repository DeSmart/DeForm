<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;
use DeForm\Request\RequestInterface;
use DeForm\Node\NodeInterface;

class DeFormSpec extends ObjectBehavior
{
    
    /**
     * @var \DeForm\Request\RequestInterface
     */
    protected $request;
    
    /**
     * @var \DeForm\Node\NodeInterface
     */
    protected $formNode;
    
    function let(NodeInterface $formNode, RequestInterface $request)
    {
        $this->formNode = $formNode;
        $this->request = $request;
        
        $this->formNode->getAttribute('name')->willReturn('foo');
        
        $this->beConstructedWith($this->formNode, $this->request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\DeForm');
    }
    
    function it_should_check_if_the_form_was_submitted()
    {
        $this->request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('foo');
        
        $this->isSubmitted()->shouldReturn(true);
    }
    
    function it_should_check_if_the_form_was_not_submitted()
    {
        $this->request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('bar');
        
        $this->isSubmitted()->shouldReturn(false);
    }

}
