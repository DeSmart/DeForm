<?php namespace DeForm\Parser;

use DeForm\Document\HtmlDocument;
use DeForm\Parser\ParserInterface;

class HtmlParser implements ParserInterface
{
  
    /**
     * Parse HTML to Nodes
     *
     * @param mixed $document
     * @return \DeForm\Node\NodeInterface[]
     */
    public function parse($document) {
      
      if (false === $document instanceof HtmlDocument) {
        throw new \InvalidArgumentException('This parser can use only HtmlDocument instance');
      }
    }
  
}
