<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface;
use DeForm\Request\RequestInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileElementSpec extends ObjectBehavior
{
    function let(NodeInterface $node, RequestInterface $request)
    {
        $this->beConstructedWith($node, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\FileElement');
        $this->shouldImplement('DeForm\Element\ElementInterface');
    }

    function it_should_be_readonly_element_based_on_disabled_attribute(NodeInterface $node)
    {
        $node->hasAttribute('readonly')->willReturn(false);
        $node->hasAttribute('disabled')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_should_be_readonly_element_based_on_readonly_attribute(NodeInterface $node)
    {
        $node->hasAttribute('disabled')->willReturn(false);
        $node->hasAttribute('readonly')->shouldBeCalled()->willReturn(true);

        $this->shouldBeReadonly();
    }

    function it_should_return_name_of_element(NodeInterface $node)
    {
        $node->getAttribute('name')->shouldBeCalled()->willReturn('foo');

        $this->getName()->shouldReturn('foo');
    }

    function it_should_set_element_as_valid(NodeInterface $node)
    {
        $node->removeAttribute('data-invalid')->shouldBeCalled();

        $this->setValid();
    }

    function it_should_set_element_as_invalid(NodeInterface $node)
    {
        $node->setAttribute('data-invalid', 'foo')->shouldBeCalled();

        $this->setInvalid('foo');
    }

    function it_should_be_valid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(false);
        $this->shouldBeValid();
    }

    function it_should_be_invalid_element(NodeInterface $node)
    {
        $node->hasAttribute('data-invalid')->shouldBeCalled()->willReturn(true);
        $this->shouldNotBeValid();
    }

    function it_should_return_element_value_from_request(NodeInterface $node, RequestInterface $request)
    {
        $node->getAttribute('name')->willReturn('foo')->shouldBeCalled();
        $request->file('foo')->willReturn('bar')->shouldBeCalled();

        $this->getValue()->shouldBe('bar');
    }

    function it_should_throws_exception_when_try_set_value_of_element()
    {
        $this->shouldThrow('\BadMethodCallException')->during('setValue', ['foo']);
    }
}
