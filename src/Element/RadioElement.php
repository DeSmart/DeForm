<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class RadioElement extends AbstractElement implements ElementInterface
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
        if ($value === $this->getValue()) {
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

    /**
     * If element has an attribute "checked" then return true.
     *
     * @return bool
     */
    public function isChecked()
    {
        return $this->node->hasAttribute('checked');
    }

    /**
     * Remove an attribute "checked" from a element.
     *
     * @return self
     */
    public function setUnchecked()
    {
        $this->node->removeAttribute('checked');

        return $this;
    }

    /**
     * Add an attribute "checked" to a element.
     *
     * @return self
     */
    public function setChecked()
    {
        $this->node->setAttribute('checked', 'checked');

        return $this;
    }

}
