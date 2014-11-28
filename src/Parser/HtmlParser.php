<?php namespace DeForm\Parser;

use DeForm\Document\HtmlDocument;
use DeForm\Parser\ParserInterface;

class HtmlParser implements ParserInterface
{

    private $html;

    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    public function getFormNode()
    {
        // TODO: write logic here
    }

    public function getElementsNodes()
    {
        // TODO: write logic here
    }
}
