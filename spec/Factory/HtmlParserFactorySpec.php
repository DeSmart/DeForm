<?php

namespace spec\DeForm\Factory;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeForm\Document\HtmlDocument;

class HtmlParserFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Factory\HtmlParserFactory');
        $this->shouldImplement('DeForm\Factory\ParserFactoryInterface');
    }

    function it_creates_document()
    {
        $document = $this->createDocument($html = '<form></form>');
        $document->shouldHaveType('DeForm\Document\HtmlDocument');
        $document->toHtml()->shouldReturn($html);
    }

    function it_creates_parser(HtmlDocument $document)
    {
        $this->createParser($document)->shouldHaveType('DeForm\Parser\HtmlParser');
    }
}
