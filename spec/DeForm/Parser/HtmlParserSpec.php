<?php

namespace spec\DeForm\Parser;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Parser\HtmlParser');
    }
}
