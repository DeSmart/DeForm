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
        if (0 === $this->countChildNodes()) {
            return null;
        }

        return $this->node->getChildNodes()->item(0)->nodeValue;
    }

    /**
     * Return number of child nodes.
     *
     * @return int
     */
    public function countChildNodes()
    {
        return $this->node->getChildNodes()->length;
    }

}
