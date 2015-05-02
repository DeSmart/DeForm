<?php

namespace spec\DeForm\Parser;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeForm\Document\HtmlDocument;
use DeForm\Document\DocumentInterface;

class HtmlParserSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Parser\ParserInterface');
    }

    function it_sets_only_html_document(DocumentInterface $document)
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetDocument($document);
    }

    function it_gets_form_node()
    {
        $document = new HtmlDocument;
        $document->load('<form method="post"><input type="text" name="foo"/></form>');

        $this->setDocument($document);

        $this->getFormNode()->shouldReturnAnInstanceOf('DeForm\Node\HtmlNode');
        $this->getFormNode()->getAttribute('method')->shouldReturn('post');
    }

    function it_gets_element_nodes()
    {
        $document = new HtmlDocument;
        $document->load('<form method="post"><input type="text" name="foo"/><input type="checkbox" name="bar"/></form>');
        $this->setDocument($document);

        $elements = $this->getElementsNodes();

        $elements->shouldHaveCount(2);
        $elements[0]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
        $elements[0]->getElementType()->shouldReturn('input_text');
        $elements[1]->shouldBeAnInstanceOf('DeForm\Node\HtmlNode');
        $elements[1]->getElementType()->shouldReturn('input_checkbox');
    }
}
