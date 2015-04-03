<?php namespace DeForm\Parser;

use DeForm\Document\HtmlDocument;
use DeForm\Node\HtmlNode;
use DeForm\Parser\ParserInterface;

class HtmlParser implements ParserInterface
{

    /**
     * @var string
     */
    protected $html;

    /**
     * @var \DOMDocument
     */
    protected $document;

    /**
     * @var \DeForm\Node\HtmlNode
     */
    protected $formNode;

    /**
     * @var \DeForm\Node\HtmlNode[]
     */
    protected $elementNodes = null;

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

    /**
     * @param string $html
     * @return $this
     */
    public function setHtml($html)
    {
        $this->html = $html;

        $this->prepareDocument();

        return $this;
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
        $xpath = new \DOMXpath($this->getDocument());
        $list = $xpath->query("//form");

        if (0 == $list->length) {
            throw new \InvalidArgumentException("Form element not found in passed HTML");
        }

        if (1 < $list->length) {
            throw new \InvalidArgumentException("More than one form found in passed HTML");
        }

        return new HtmlNode($list->item(0), $this->getDocument());
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

    protected function prepareDocument()
    {
        if (true === empty($this->html)) {
            return;
        }

        $html = mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8');
        $this->document = new \DOMDocument();
        $this->document->loadHTML($html);
    }

    /**
     * @return \DOMDocument
     */
    protected function getDocument()
    {
        return $this->document;
    }

    /**
     * Searches for form elements in HTML code
     *
     * @return \DeForm\Node\HtmlNode[]
     */
    protected function fetchElementNodes()
    {
        $xpath = new \DOMXpath($this->getDocument());
        $elements = [];

        foreach ($this->map as $query) {
            $list = $xpath->query($query);

            if (0 == $list->length) {
                continue;
            }

            foreach ($list as $node) {
                $elements[] = new HtmlNode($node, $this->getDocument());
            }
        }

        return $elements;
    }

}
