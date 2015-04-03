<?php

namespace spec\DeForm\Element;

use DeForm\Node\NodeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SelectElementSpec extends ObjectBehavior
{
    function let(NodeInterface $nodeInterface)
    {
        $this->beConstructedWith($nodeInterface);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeForm\Element\SelectElement');
    }

    function it_should_return_value_of_element_single_select(NodeInterface $nodeInterface, \DOMElement $domElement)
    {
        $attribute = "selected";
        $value = "selected";

        $domElement->getAttribute($attribute)->willReturn($value);
        $results = [];
        $results[] = $domElement;

        $nodeInterface->getChildElementByAttribute($attribute, $value)->willReturn($results);

        $domElement->getAttribute('value')->willReturn(2);

        $this->getValue()->shouldReturn(2);
    }

    function it_should_return_value_of_element_multi_select(NodeInterface $nodeInterface, \DOMElement $domElement, \DOMElement $domElement2)
    {
        $attribute = "selected";
        $value = "selected";

        $domElement->getAttribute($attribute)->willReturn($value);
        $domElement2->getAttribute($attribute)->willReturn($value);
        $results = [];
        $results[] = $domElement;
        $results[] = $domElement2;

        $nodeInterface->getChildElementByAttribute($attribute, $value)->willReturn($results);

        $domElement->getAttribute('value')->willReturn(2);
        $domElement2->getAttribute('value')->willReturn(3);

        $this->getValue()->shouldReturn([2, 3]);
    }

    function it_should_set_value_for_single_select_element(NodeInterface $nodeInterface)
    {
        $value = 2;

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

        $nodeInterface->getChildNodes()->willReturn($node->childNodes);
        $nodeInterface->getChildElementByAttribute('value', $value)->willReturn($results);

        $this->setValue($value);
    }

    function it_should_set_value_for_multi_select_element(NodeInterface $nodeInterface)
    {
        $value = [2, 3];

        $document = new \DOMDocument('1.0', 'utf-8');
        $node = $document->createElement('select');
        $option_1 = $document->createElement('option');
        $option_1->setAttribute('value', '1');

        $option_2 = $document->createElement('option');
        $option_2->setAttribute('value', '2');

        $option_3 = $document->createElement('option');
        $option_3->setAttribute('value', '3');

        $node->appendChild($option_1);
        $node->appendChild($option_2);
        $node->appendChild($option_3);

        $results = [];
        $results[] = $option_2;
        $results[] = $option_3;

        $nodeInterface->getChildNodes()->willReturn($node->childNodes);
        $nodeInterface->getChildElementByAttribute('value', $value)->willReturn($results);

        $this->setValue($value);
    }

    function it_should_add_option_to_select_element(NodeInterface $nodeInterface, NodeInterface $optionElement)
    {
        $tag_name = "option";
        $value = 2;
        $text_value = "Option";

        $nodeInterface->createElement($tag_name, $text_value)->willReturn($optionElement);
        $nodeInterface->appendChild($optionElement)->shouldBeCalled();

        $optionElement->setAttribute('value', $value)->shouldBeCalled();

        $this->addOption($text_value, $value);
    }

    function it_should_add_options_to_select_element(NodeInterface $nodeInterface, NodeInterface $optionElement1, NodeInterface $optionElement2, NodeInterface $optionElement3)
    {
        $tag_name = "option";
        $data = [
            1 => 'option1',
            2 => 'option2',
            3 => 'option3',
        ];

        $nodeInterface->createElement($tag_name, $data[1])->willReturn($optionElement1);
        $nodeInterface->appendChild($optionElement1)->shouldBeCalled();
        $optionElement1->setAttribute('value', 1)->shouldBeCalled();

        $nodeInterface->createElement($tag_name, $data[2])->willReturn($optionElement2);
        $nodeInterface->appendChild($optionElement2)->shouldBeCalled();
        $optionElement2->setAttribute('value', 2)->shouldBeCalled();

        $nodeInterface->createElement($tag_name, $data[3])->willReturn($optionElement3);
        $nodeInterface->appendChild($optionElement3)->shouldBeCalled();
        $optionElement3->setAttribute('value', 3)->shouldBeCalled();

        $this->addOption($data);
    }
}
