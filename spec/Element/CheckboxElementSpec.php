<?php

namespace spec\DeForm\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/** @mixin \DeForm\Element\CheckboxElement */
class CheckboxElementSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\CheckboxElement');
        $this->shouldImplement('DeForm\Element\ElementInterface');
    }
}
