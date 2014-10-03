<?php

namespace spec\DeForm\Node;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlNodeSpec extends ObjectBehavior
{
    function let(\DOMElement $element) 
    {
        $this->beConstructedWith($element);
    }
  
    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Node\HtmlNode');
    }
    
    function it_returns_node_attribute(\DOMElement $element)
    {
        $element->getAttribute('name')->willReturn('foo');
        $this->getAttribute('name')->shouldReturn('foo');
    }
    
    function it_sets_node_attribute(\DOMElement $element)
    {
        $element->setAttribute('name', 'foo')->shouldBeCalled();
        $this->setAttribute('name', 'foo');
    }
    
    function it_returns_element_type_when_node_has_type_attribute()
    {
        $document = new \DOMDocument('1.0');
        $element = $document->appendChild($document->createElement('input'));
        $element->setAttribute('type', 'password');

        $this->beConstructedWith($element);
        $this->getElementType()->shouldReturn('input_password');
    }
    
    function it_returns_element_type_when_node_has_only_node_name(\DOMElement $element)
    {
        $document = new \DOMDocument('1.0');
        $element = $document->appendChild($document->createElement('textarea'));
      
        $this->beConstructedWith($element);
        $this->getElementType()->shouldReturn('textarea');
    }
    
    function it_checks_if_node_has_attribute(\DOMElement $element) 
    {
      $element->hasAttribute('foo')->willReturn(false);
      $this->hasAttribute('foo')->shouldReturn(false);
    }
    
    function it_removes_node_attribute(\DOMElement $element)
    {
        $element->removeAttribute('name')->shouldBeCalled();
        $this->removeAttribute('name');
    }
    
    function it_returns_node(\DOMElement $element)
    {
        $this->getDomElement()->shouldEqual($element);
    }
    
    function it_appends_html_node(\DOMElement $element, \DeForm\Node\HtmlNode $htmlNode)
    {
        $node = new \DOMElement('input');
        $element->appendChild($node)->shouldBeCalled();
        $htmlNode->getDomElement()->willReturn($node);
          
        $this->appendChild($htmlNode);
    }
    
    function it_throws_exception_when_appending_non_html_node(\DeForm\Node\NodeInterface $node) 
    {
        $this->shouldThrow('\InvalidArgumentException')->during('appendChild', [$node]);
    }
    
    
}
