<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class TextareaElement extends AbstractElement implements ElementInterface
{

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        if (false === is_string($value) && false === is_numeric($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be string or numeric.');
        }

        foreach ($this->node->getChildNodes() as $node) {
            $this->node->removeChildNode($node);
        }

        $this->node->setText($value);
        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        $child_nodes = $this->node->getChildNodes();

        if (0 === $child_nodes->length) {
            return null;
        }

        return $child_nodes->item(1)->wholeText;
    }

}
