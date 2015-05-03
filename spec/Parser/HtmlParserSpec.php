<?php

namespace spec\DeForm\Parser;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeForm\Document\HtmlDocument;

class HtmlParserSpec extends ObjectBehavior
{

    function it_gets_form_node()
    {
        $document = new HtmlDocument('<form method="post"><input type="text" name="foo"/></form>');

        $this->beConstructedWith($document);

        $this->getFormNode()->shouldReturnAnInstanceOf('DeForm\Node\HtmlNode');
        $this->getFormNode()->getAttribute('method')->shouldReturn('post');
    }

    function it_gets_element_nodes()
    {
        $document = new HtmlDocument('<form method="post"><input type="text" name="foo"/><input type="checkbox" name="bar"/></form>');
        $this->beConstructedWith($document);

        $elements = $this->getElementsNodes();

        $elements->shouldHaveCount(2);
        $elements[0]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
        $elements[0]->getElementType()->shouldReturn('input_text');
        $elements[1]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
        $elements[1]->getElementType()->shouldReturn('input_checkbox');
    }
}
