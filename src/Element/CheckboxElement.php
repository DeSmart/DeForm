<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class CheckboxElement extends AbstractElement implements ElementInterface
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
     * @throws \InvalidArgumentException
     */
    public function setValue($value)
    {
        if (false === is_string($value) && false === is_numeric($value)) {
            throw new \InvalidArgumentException('Invalid type of $value. Should be string or numeric.');
        }

        if ((string) $value === $this->getValue()) {
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
        return $this->node->getAttribute('value');
    }

}
