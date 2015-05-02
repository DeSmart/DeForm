<?php namespace DeForm\Parser;

use DeForm\Document\DocumentInterface;

interface ParserInterface
{

    /**
     * Set parsed document
     *
     * @param \DeForm\Document\DocumentInterface $document
     */
    public function setDocument(DocumentInterface $document);

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
