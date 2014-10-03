<?php namespace DeForm\Node;

interface NodeInterface
{

    /**
     * Return node type based on it's name and type.
     *
     * This will be used to generate class name
     *
     * @example input_radio
     * @return string
     */
    public function getElementType();

    /**
     * Get node's attribute value
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name);

    /**
     * Set node's attribute value
     *
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value);

    /**
     * Check if node has set an attribute
     *
     * @param string name
     * @return boolean
     */
    public function hasAttribute($name);

    /**
     * Remove node's attribute
     *
     * @param string $name
     */
    public function removeAttribute($name);

    /**
     * Append child to node
     *
     * @param mixed $node
     */
    public function appendChild($node);

}
