<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;
use DeForm\Request\RequestInterface;
use DeForm\Node\NodeInterface;

class DeFormSpec extends ObjectBehavior
{
    
    function let(NodeInterface $formNode, RequestInterface $request)
    {
        $formNode->getAttribute('name')->willReturn('foo');
        $this->beConstructedWith($formNode, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\DeForm');
    }
    
    function it_should_check_if_the_form_was_submitted(NodeInterface $formNode, RequestInterface $request)
    {
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('foo');
        $this->isSubmitted()->shouldReturn(true);
    }
    
    function it_should_check_if_the_form_was_not_submitted(NodeInterface $formNode, RequestInterface $request)
    {
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('bar');
        $this->isSubmitted()->shouldReturn(false);
    }
}
