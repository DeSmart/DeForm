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
    
    function it_throws_exception_when_parse_get_non_html_document(\DeForm\Parser\ParserInterface $parser)
    {
        $this->shouldThrow('\InvalidArgumentException')->during('parse', [$parser]);
    }
    
    function it_finds_form_element(HtmlDocument $document)
    {
    
    }
    
}
