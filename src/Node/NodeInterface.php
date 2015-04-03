<?php namespace DeForm\Node;

interface NodeInterface
{

    /**
     * Return node type based on it's name and type.
     *
     * This will be used to generate class name.
     *
     * @example input_radio
     * @return string
     */
    public function getElementType();

    /**
     * Get node's attribute value.
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Set node's attribute value.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setAttribute($name, $value);

    /**
     * Check if node has set an attribute.
     *
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name);

    /**
     * Remove node's attribute.
     *
     * @param string $name
     * @return boolean
     */
    public function removeAttribute($name);

    /**
     * Append child to node.
     *
     * @param mixed $node
     * @return void
     */
    public function appendChild($node);

    /**
     * Get child nodes of element.
     *
     * @return \DOMNodeList
     */
    public function getChildNodes();

    /**
     * Remove child node from element.
     *
     * @param $node
     * @return void
     */
    public function removeChildNode($node);

    /**
     * Sets text value of element.
     *
     * @param string $text
     * @return void
     */
    public function setText($text);

    /**
     * Get text value of element.
     *
     * @return string
     */
    public function getText();

    /*
     * Get child node by given attribute and value
     *
     * @param $attribute
     * @param $value
     * @return array
     */
    public function getChildElementByAttribute($attribute, $value);

    /**
     * Create new node element
     *
     * @param $name
     * @param null $textValue
     * @return \DeForm\Node\NodeInterface
     */
    public function createElement($name, $textValue = null);
}
