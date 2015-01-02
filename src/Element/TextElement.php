<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class TextElement extends AbstractElement implements ElementInterface
{

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * Set the value of a form element.
     *
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->node->setAttribute('value', $value);

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return string|int
     */
    public function getValue()
    {
        return $this->node->getAttribute('value');
    }

}
