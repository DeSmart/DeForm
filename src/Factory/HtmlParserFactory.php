<?php namespace DeForm\Factory;

use DeForm\Parser\HtmlParser;
use DeForm\Document\HtmlDocument;

class HtmlParserFactory implements ParserFactoryInterface
{

    public function createDocument($html)
    {
        return new HtmlDocument($html);
    }

    public function createParser($document)
    {
        return new HtmlParser($document);
    }
}
