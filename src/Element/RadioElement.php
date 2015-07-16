<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class RadioElement extends AbstractElement
{
    use CheckedAttributeTrait;

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * Set the value of a form element.
     *
     * @param mixed $value
     * @return self
     */
    public function setValue($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (true === $value) {
            $this->setChecked();
        } else {
            $this->setUnchecked();
        }

        return $this;
    }

    /**
     * Get the value of a form element.
     *
     * @return mixed
     */
    public function getValue()
    {
        if (false === $this->isChecked()) {
            return null;
        }

        return $this->node->getAttribute('value');
    }
}
