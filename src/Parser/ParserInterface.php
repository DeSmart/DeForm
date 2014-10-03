<?php namespace DeForm\Parser;

use DeForm\Document\DocumentInterface;

interface ParserInterface 
{
    
    /**
     * Parse HTML to Nodes
     *
     * @param \DeForm\Document\DocumentInterface $document
     * @return \DeForm\Node\NodeInterface[]
     */
    public function parse(DocumentInterface $document);

}
