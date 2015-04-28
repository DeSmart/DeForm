<?php

namespace spec\DeForm\Node;

use DeForm\Node\NodeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlNodeSpec extends ObjectBehavior
{
    function let(\DOMElement $element, \DOMDocument $document)
    {
        $this->beConstructedWith($element, $document);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Node\HtmlNode');
        $this->shouldImplement('DeForm\Node\NodeInterface');
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

        $this->beConstructedWith($element, $document);
        $this->getElementType()->shouldReturn('input_password');
    }

    function it_returns_element_type_when_node_has_only_node_name(\DOMElement $element)
    {
        $document = new \DOMDocument('1.0');
        $element = $document->appendChild($document->createElement('textarea'));

        $this->beConstructedWith($element, $document);
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

    function it_appends_html_node(\DOMElement $element, \DOMElement $node, \DeForm\Node\HtmlNode $htmlNode)
    {
        $node->C14N()->willReturn('<input />');
        $element->appendChild($node)->shouldBeCalled();
        $htmlNode->getDomElement()->willReturn($node);

        $this->appendChild($htmlNode);
    }

    function it_throws_exception_when_appending_non_html_node(\DeForm\Node\NodeInterface $node)
    {
        $this->shouldThrow('\InvalidArgumentException')->during('appendChild', [$node]);
    }

    function it_sets_text()
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $element = $document->createElement('textarea');

        $this->beConstructedWith($element, $document);

        $this->setText('test');
        $this->getText()->shouldReturn('test');
    }

    function it_does_not_append_text()
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $element = $document->createElement('textarea');

        $this->beConstructedWith($element, $document);

        $this->setText('test');
        $this->setText('test123');

        $this->getText()->shouldReturn('test123');
    }

    function it_return_empty_string_if_textarea_is_empty(\DOMDocument $document)
    {
        $element = new \DOMElement('textarea');

        $this->beConstructedWith($element, $document);
        $this->getText()->shouldReturn('');
    }

    function it_return_text_value(\DOMDocument $document)
    {
        $element = new \DOMElement('textarea', 'foobar');

        $this->beConstructedWith($element, $document);
        $this->getText()->shouldReturn('foobar');
    }

    function it_should_return_child_element_by_its_attribute_and_value(\DOMDocument $domDocument)
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $node = $document->createElement('select');
        $option_1 = $document->createElement('option');
        $option_1->setAttribute('value', '1');

        $option_2 = $document->createElement('option');
        $option_2->setAttribute('value', '2');

        $node->appendChild($option_1);
        $node->appendChild($option_2);

        $results = [];
        $results[] = $option_2;

        $this->beConstructedWith($node, $domDocument);
        $this->getChildElementByAttribute('value', '2')->shouldReturn($results);
    }

    function it_should_return_null_when_no_child_element_found_by_attribute_and_value(\DOMDocument $domDocument)
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $node = $document->createElement('select');
        $option_1 = $document->createElement('option');
        $option_1->setAttribute('value', '1');

        $option_2 = $document->createElement('option');
        $option_2->setAttribute('value', '2');

        $node->appendChild($option_1);
        $node->appendChild($option_2);

        $results = [];

        $this->beConstructedWith($node, $domDocument);
        $this->getChildElementByAttribute('value', '3')->shouldReturn($results);
    }

    function it_should_be_able_to_create_element()
    {
        $name = "option";
        $text_value = "Option";

        $document = new \DOMDocument('1.0', 'utf-8');
        $element = $document->createElement('select');
        $document->appendChild($element);

        $this->beConstructedWith($element, $document);
        $this->createElement($name, $text_value)->shouldReturnNode($name, $text_value);
    }

    function getMatchers()
    {
        return [
            'returnNode' => function ($node, $tagName, $textValue) {

                if (false === $node instanceof \DeForm\Node\HtmlNode) {
                    return false;
                }

                $node = $node->getDomElement();

                if ($node->tagName !== $tagName) {
                    return false;
                }

                if ($node->childNodes->item(0)->textContent !== $textValue) {
                    return false;
                }

                return true;
            }
        ];
    }
}
