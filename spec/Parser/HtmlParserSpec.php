<?php

namespace spec\DeForm\Parser;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeForm\Document\HtmlDocument;

class HtmlParserSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Parser\ParserInterface');
    }

    function it_gets_form_node()
    {
        $this->setHtml('<form method="post"><input type="text" name="foo"/></form>');

        $this->getFormNode()->shouldReturnAnInstanceOf('DeForm\Node\HtmlNode');
        $this->getFormNode()->getAttribute('method')->shouldReturn('post');
    }

    function it_gets_element_nodes()
    {
        $this->setHtml('<form method="post"><input type="text" name="foo"/><input type="checkbox" name="bar"/></form>');

        $elements = $this->getElementsNodes();

        $elements->shouldHaveCount(2);
        $elements[0]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
        $elements[1]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
    }

}
