<?php namespace DeForm\Parser;

interface ParserInterface
{

    /**
     * Returns main DOM node of the whole form
     *
     * @return \DeForm\Node\NodeInterface
     */
    public function getFormNode();

    /**
     * Returns array of form element nodes (inputs, buttons?)
     *
     * @return array
     */
    public function getElementsNodes();
}
