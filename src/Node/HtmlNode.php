<?php namespace DeForm\Node;

class HtmlNode implements NodeInterface
{

    /**
     * @var \DOMElement
     */
    protected $element;

    /**
     * @var \DOMDocument
     */
    protected $document;

    public function __construct(\DOMElement $element, \DOMDocument $document)
    {
        $this->element = $element;
        $this->document = $document;
    }

    /**
     * Append child to node.
     *
     * @param mixed $node
     * @return void
     */
    public function appendChild($node)
    {
        if (false === $node instanceof HtmlNode) {
            throw new \InvalidArgumentException('Unsupported node type');
        }

        $this->element->appendChild($node->getDomElement());
    }

    /**
     * Get node's attribute value.
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return $this->element->getAttribute($name);
    }

    /**
     * Set node's attribute value.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->element->setAttribute($name, $value);
    }

    /**
     * Return node type based on it's name and type.
     *
     * This will be used to generate class name.
     *
     * @example input_radio
     * @return string
     */
    public function getElementType()
    {
        $type = sprintf('%s_%s', $this->element->tagName, $this->element->getAttribute('type'));

        return trim($type, '_');
    }

    /**
     * Check if node has set an attribute.
     *
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name)
    {
        return $this->element->hasAttribute($name);
    }

    /**
     * Remove node's attribute
     *
     * @param string $name
     * @return boolean
     */
    public function removeAttribute($name)
    {
        return $this->element->removeAttribute($name);
    }

    /**
     * Return DOM Element.
     *
     * @return \DOMElement
     */
    public function getDomElement()
    {
        return $this->element;
    }

    public function setText($text)
    {
        $text_node = $this->document->createTextNode($text);
        $this->element->appendChild($text_node);
    }

}
