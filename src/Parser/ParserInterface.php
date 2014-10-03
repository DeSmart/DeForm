<?php namespace DeForm\Parser;

interface ParserInterface 
{
    
    /**
     * Parse HTML to Nodes
     *
     * @param mixed $document
     * @return \DeForm\Node\NodeInterface[]
     */
    public function parse($document);

}
