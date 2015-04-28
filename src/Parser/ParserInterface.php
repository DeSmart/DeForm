<?php namespace DeForm\Parser;

interface ParserInterface
{

    /**
     * Set the html being parsed
     *
     * @param string $html
     */
    public function setHtml($html);

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
