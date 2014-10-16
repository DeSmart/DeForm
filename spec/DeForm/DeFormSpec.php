<?php

namespace spec\DeForm;

use PhpSpec\ObjectBehavior;

class DeFormSpec extends ObjectBehavior
{
    function let($request)
    {
        $request->beADoubleOf('\DeForm\Request\RequestInterface');
        $request->__deform_id = 'foo';
        
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\DeForm');
    }
    
    function it_should_check_if_the_form_was_submitted()
    {
//        var_dump($this->request);
//        die;
        $this->isSubmitted()->shouldReturn(true);
    }

}
