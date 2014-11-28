<?php namespace DeForm\Parser;

use DeForm\Document\HtmlDocument;
use DeForm\Node\HtmlNode;
use DeForm\Parser\ParserInterface;

class HtmlParser implements ParserInterface
{

    protected $html;

    protected $formNode;

    protected $elementNodes = [];

    protected $map = array(
        '//input[@type="text" or @type="password" or @type="email" or @type="date" or @type="hidden"]',
        '//textarea',
        '//input[@type="radio"]',
        '//input[@type="checkbox"]',
        '//input[@type="file"]',
        '//input[@type="button" or @type="submit" or @type="reset"]',
        '//button',
        '//select',
    );

    public function setHtml($html)
    {
        $this->html = $html;

        $this->parse();

        return $this;
    }

    public function getFormNode()
    {
        return $this->formNode;
    }

    public function getElementsNodes()
    {
        return $this->elementNodes;
    }

    protected function parse()
    {
        if (true === empty($this->html)) {
            return;
        }

        $html = mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8');
        $document = new \DOMDocument();
        $document->loadHTML($html);
        $xpath = new \DOMXpath($document);

        $this->parseFormNode($xpath);
        $this->parseElementNodes($xpath);
    }

    protected function parseFormNode(\DOMXpath $xpath)
    {
        $list = $xpath->query("//form");

        if (0 == $list->length) {
            throw new \InvalidArgumentException("Form element not found in passed HTML");
        }

        if (1 < $list->length) {
            throw new \InvalidArgumentException("More than one form found in passed HTML");
        }

        $this->formNode = new HtmlNode($list->item(0));

        return $this;
    }

    protected function parseElementNodes(\DOMXpath $xpath)
    {
        foreach ($this->map as $query) {
            $list = $xpath->query($query);

            if (0 == $list->length) {
                continue;
            }

            foreach ($list as $node) {
                $this->elementNodes[] = new HtmlNode($node);
            }
        }
    }

}
