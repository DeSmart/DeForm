<?php namespace DeForm\Element;

use DeForm\Node\NodeInterface;

class CheckboxElement extends AbstractElement
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
        $boolean_value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (null === $boolean_value) {
            throw new \InvalidArgumentException(sprintf('Param $value should be boolean, given %s', gettype($value)));
        }

        if (true === $boolean_value) {
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
        $has_value = $this->node->hasAttribute('value');

        if (true === $this->isChecked()) {
            return (true === $has_value) ? $this->node->getAttribute('value') : true;
        }

        return (true === $has_value) ? null : false;
    }

    /**
     * Return the name of a form element.
     *
     * @return string
     */
    public function getName()
    {
        $name = parent::getName();

        if ('[]' !== substr($name, -2)) {
            return $name;
        }

        $length = strlen($name);
        return substr($name, 0, $length - 2);
    }
}
