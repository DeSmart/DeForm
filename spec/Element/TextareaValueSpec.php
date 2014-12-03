<?php

namespace spec\DeForm\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextareaValueSpec extends ObjectBehavior
{
    function let()
    {
        $text = new \DOMText('abc');
        $this->beConstructedWith($text);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\TextareaValue');
        $this->shouldImplement('DeForm\Element\TextareaValueInterface');
    }

    function it_return_text_value()
    {
        $this->getValue()->shouldReturn('abc');
    }

    function it_should_set_return_value_on_foo()
    {
        $this->setValue('foo')->shouldHaveType('DeForm\Element\TextareaValue');
        $this->getValue()->shouldReturn('foo');
    }

}
