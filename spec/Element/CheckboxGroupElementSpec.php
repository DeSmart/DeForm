<?php

namespace spec\DeForm\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\CheckboxGroupElement */
class CheckboxGroupElementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\CheckboxGroupElement');
        $this->shouldImplement('DeForm\Element\GroupInterface');
    }
}
