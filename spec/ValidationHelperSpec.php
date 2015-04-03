<?php

namespace spec\DeForm;

use DeForm\Validation\ValidatorFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidationHelperSpec extends ObjectBehavior
{
    function let(ValidatorFactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\ValidationHelper');
    }
}
