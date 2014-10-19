<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;

class DeFormSpec extends ObjectBehavior
{
    function let($formNode, $request)
    {
        $request->beADoubleOf('\DeForm\Request\RequestInterface');
        $request->get(\DeForm\DeForm::DEFORM_ID)->willReturn('foo');
        
        $formNode->beADoubleOf('\DeForm\Node\NodeInterface');
        $formNode->getAttribute('name')->willReturn('foo');
        
        $this->beConstructedWith($formNode, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\DeForm');
    }
    
    function it_should_check_if_the_form_was_submitted()
    {
        $this->isSubmitted()->shouldReturn(true);
    }

}
