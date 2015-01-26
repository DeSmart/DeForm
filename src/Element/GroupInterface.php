<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

interface GroupInterface extends ElementInterface
{

    /**
     * Add new element to group.
     *
     * @param \DeForm\Node\NodeInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(NodeInterface $element);

    /**
     * Return all elements from group.
     *
     * @return \DeForm\Node\NodeInterface[]
     */
    public function getElements();

    /**
     * Return a single element of group based on value name.
     *
     * @param string $value
     * @return \DeForm\Node\NodeInterface
     * @throw \InvalidArgumentException
     */
    public function getElement($value);

}