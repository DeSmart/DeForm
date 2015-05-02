<?php namespace DeForm\Parser;

use DeForm\Node\HtmlNode;
use DeForm\Document\HtmlDocument;
use DeForm\Parser\ParserInterface;
use DeForm\Document\DocumentInterface;

class HtmlParser implements ParserInterface
{

    /**
     * @var \DeForm\Node\HtmlNode
     */
    protected $formNode;

    /**
     * @var \DeForm\Node\HtmlNode[]
     */
    protected $elementNodes = null;

    /**
     * @var \DeForm\Document\HtmlDocument
     */
    protected $document;

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

    public function setDocument(DocumentInterface $document)
    {

        if (false === $document instanceof HtmlDocument) {
            throw new \InvalidArgumentException('Only HtmlDocument allowed');
        }

        $this->document = $document;
    }

    /**
     * Returns the main <form> Node
     *
     * @return \DeForm\Node\HtmlNode
     */
    public function getFormNode()
    {
        if (true === empty($this->formNode)) {
            $this->formNode = $this->fetchFormNode();
        }

        return $this->formNode;
    }

    /**
     * Searches for main form element in HTML code
     *
     * @return \DeForm\Node\HtmlNode
     */
    protected function fetchFormNode()
    {
        $xpath = new \DOMXpath($this->document->getDocument());
        $list = $xpath->query("//form");

        if (0 == $list->length) {
            throw new \InvalidArgumentException("Form element not found in passed HTML");
        }

        if (1 < $list->length) {
            throw new \InvalidArgumentException("More than one form found in passed HTML");
        }

        return new HtmlNode($list->item(0), $this->document->getDocument());
    }

    /**
     * Returns all found form elements as HtmlNodes
     *
     * @return \DeForm\Node\HtmlNode[]
     */
    public function getElementsNodes()
    {
        if (null === $this->elementNodes) {
            $this->elementNodes = $this->fetchElementNodes();
        }

        return $this->elementNodes;
    }

    /**
     * Searches for form elements in HTML code
     *
     * @return \DeForm\Node\HtmlNode[]
     */
    protected function fetchElementNodes()
    {
        $xpath = new \DOMXpath($this->document->getDocument());
        $elements = [];

        foreach ($this->map as $query) {
            $list = $xpath->query($query);

            if (0 == $list->length) {
                continue;
            }

            foreach ($list as $node) {
                $elements[] = new HtmlNode($node, $this->document->getDocument());
            }
        }

        return $elements;
    }
}
