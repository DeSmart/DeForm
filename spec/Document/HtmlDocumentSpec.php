<?php namespace spec\DeForm\Document;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlDocumentSpec extends ObjectBehavior
{

    private $html;

    function let()
    {
        $this->html = '<div><form method="post"><input type="password" name="pwd"></form></div>';
        $this->load($this->html);
    }

    function it_should_load_a_string_and_convert_it_to_domdocument()
    {
        $this->getDocument()->shouldHaveType('DOMDocument');
    }

    function it_should_load_a_string_and_return_the_same_string()
    {
        $this->toHtml()->shouldReturn($this->html);
    }

    function it_finds_by_xpath()
    {
        $this->xpath('//form')->shouldReturnNode('form', [
            'method' => 'post',
        ]);

        $this->xpath('//input[@type="password"]')->shouldReturnNode('input', [
            'type' => 'password',
            'name' => 'pwd',
        ]);
    }

    function getMatchers()
    {
        return [
            'returnNode' => function ($value, $tagName, $expectedAttrs = []) {
                $node = $value[0];

                if (false === $node instanceof \DOMElement) {
                    return false;
                }

                if ($node->tagName !== $tagName) {
                    return false;
                }

                foreach ($expectedAttrs as $name => $value) {
                    if ($node->getAttribute($name) != $value) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }

}
