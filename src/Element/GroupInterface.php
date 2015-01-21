<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

interface GroupInterface extends ElementInterface
{

    /**
     * @param \DeForm\Node\NodeInterface $element
     * @return self
     * @throw \InvalidArgumentException
     */
    public function addElement(NodeInterface $element);

}